<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Type;
use App\Models\Types_Articles;
use App\Models\WatchedArticles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ArticleFollowersAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\alert;

class ArticleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index($id = null)
  {
    if ($id != null) {
      $user = User::findOrFail($id);
    } else {
      $user = Auth::user();
    }
    $articles = $user->articles()->orderBy('created_at', 'desc')->paginate(10);
    $pages_link = $articles->onEachSide(5);
    if ($articles->lastPage() < $articles->currentPage()) {
      return view('404');
    }
    return view('pages.articles.articles', compact(['user', 'articles', 'pages_link']));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $types = Type::get();
    return view('pages.articles.write_article', compact(['types']));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validate Data
    $request->validate([
      'title' => ['required', 'min:3', 'max:256'],
      'id_types' => ['required'],
      'bgArticle' => ['required', File::types(['png', 'jpg', 'jpeg', 'webp'])->max(12 * 1024)],
      'content' => ['required', 'min:50'],
    ]);

    // Check From Comment Allow Or not
    if ($request->comment == 'on') {
      $comments = 'allow';
    } else {
      $comments = 'disable';
    }

    // Move BgArticle
    $imageName = Auth::user()->id . time() . '.' . $request->bgArticle->extension();
    if ($request->hasFile("bgArticle")) {
      $imageName = Storage::disk('bgArticles')->putFileAs(
        '/',
        $request->file("bgArticle"),
        $imageName
      );
    }

    // Add Article
    Article::create([
      'title' => $request->title,
      'id_user' => Auth::user()->id,
      'content' => $request->content,
      'bgArticle' =>   $imageName,
      'comment' => $comments,
    ]);

    // Add Tags For This Article
    $id_article = Article::select("id")->latest()->first()->id;
    foreach ($request->id_types as $id) {
      Types_Articles::create([
        'id_article' => $id_article,
        'id_type' => $id,
      ]);
    }

    // Send Notification For Followers
    $followers_id = Auth::user()->followers->pluck("id_user");
    $followers = User::whereIn("id", $followers_id)->get();
    Notification::send($followers, new ArticleFollowersAuthor($id_article, Auth::user()->id));

    return back()->with("message", __("messages.article.add"));
  }

  /**
   * Display the specified resource.
   */
  public function show($user_id, $id)
  {
    $article = Article::findOrFail($id);
    if ($article->hidden !== null) { // Check IF This Article Blocked?
      return redirect("index");
    }

    // Get Recommend Article Have Same Type
    $typeIds = $article->types()->pluck('types.id')->toArray();
    $recommend_articles = Article::whereNull('hidden')->whereHas('types', function ($query) use ($typeIds) {
      $query->whereIn('types.id', $typeIds); // Get recommend Articles By Type
    })->select('id_user', 'id', 'bgArticle', 'title')->whereNot('id', $id)->limit(4)->get();

    // Watched Article
    $currentUrl = url()->current();
    $key = 'viewed_urls';
    $viewedUrls = Cache::get($key, []);
    if (!in_array($currentUrl, $viewedUrls)) {
      $viewedUrls[] = $currentUrl;
      Cache::put($key, $viewedUrls, 180); // 3 Minutes
      $article->increment('watched', 1);
    }

    if (Auth::user()) {
      // Added Article in history's user
      $article->WatchedArticles()->updateOrCreate(
        [
          'id_article' => $article->id,
          'id_user' => Auth::user()->id,
        ],
        [
          'updated_at' => now()
        ]
      );

      // Mark Notification As Readed
      Auth::user()->unreadNotifications()->where("data->id_article", $article->id)->get()->markAsRead();
    }

    return view("pages.articles.readArticle", compact("article", 'recommend_articles'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id_user, $id_article)
  {
    $article = Article::where('id', $id_article)->firstOrFail();
    if (Auth::user()->can('articles-controll') || Auth::user()->id == $article->id_user) {
      $types = Type::all();
      $types_article = $article->types()->pluck('id_type')->toArray();
      return view('pages.articles.write_article', compact(['article', 'types', 'types_article']));
    }
    return view("404");
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id_article)
  {
    $article = Article::where('id', $id_article)->firstOrFail();
    if (Auth::user()->can('articles-controll') || Auth::user()->id == $article->id_user) {
      // Validate Data
      $request->validate([
        'title' => ['required', 'min:3', 'max:256'],
        'id_types' => ['required'],
        'bgArticle' => [File::types(['png', 'jpg', 'jpeg', 'webp'])->max(12 * 1024)],
        'content' => ['required', 'min:50'],
      ]);

      // Check From Comment Allow Or not
      if ($request->comment == 'on') {
        $comments = 'allow';
      } else {
        $comments = 'disable';
      }

      // Move BgArticle
      if ($request->hasFile("bgArticle")) {
        @unlink("bgArticles/" . $article->bgArticle);
        $imageName = Auth::user()->id . time() . '.' . $request->bgArticle->extension();
        $request->bgArticle->move(public_path('bgArticles'), $imageName);
      }

      // Save Edit in Article
      $article->update([
        'title' => $request->title,
        'content' => $request->content,
        'bgArticle' => isset($imageName) ? $imageName : $article->bgArticle,
        'comment' => $comments
      ]);

      // Add Tags For This Article
      Types_Articles::where('id_article', $id_article)->delete();
      foreach ($request->id_types as $id) {
        Types_Articles::create([
          'id_article' => $id_article,
          'id_type' => $id,
        ]);
      }

      return back()->with("message",  __("messages.article.edit"));
    }
    return view("404");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    // Check If User His This Article
    $isHis = Auth::user()->articles()->where('articles.id', $request->id)->firstOrFail();
    @unlink("bgArticles/" . $isHis->bgArticle);

    DB::table("notifications")->where("data->id_article", $isHis->id)->delete(); // delet notifications

    $isHis->delete();
    return back()->with("message",  __("messages.article.delete"));
  }

  public function static($user_id, $id)
  {
    $article = Article::where([['id_user', $user_id], ['id', $id]])->firstOrFail();

    if (Auth::user()->can('articles-controll') || Auth::user()->can('articles-show')  || Auth::user()->id == $article->id_user) {
      $human_readable = new \NumberFormatter(
        'en_US',
        \NumberFormatter::PADDING_POSITION
      );
      $likes = $article->whereHas('ReactionArticles', function ($query) {
        $query->where('action', 1);
      })->count();
      $disLikes = $article->whereHas('ReactionArticles', function ($query) {
        $query->where('action', 0);
      })->count();

      // get view in one month
      $watchedStaticMonthForYear = function ($article, $year) {
        $watchedMonths = [];
        for ($i = 1; $i <= 12; $i++) {
          $watchedMonths["$year-" . (($i < 10) ? "0" : '') . "$i-01"] = WatchedArticles::where('id_article', $article->id)->whereYear('updated_at', $year)->whereMonth('updated_at', $i)->count();
        }
        return $watchedMonths;
      };

      // Get Count Users By Type
      $watchedTypeUser = function ($article, $type) {
        return $article->WatchedArticles()->whereHas("user", function ($query) use ($type) {
          $query->where('type', $type);
        })->count();
      };

      return view("pages.articles.statisticArticle", compact(['article', 'human_readable', 'likes', 'disLikes', 'watchedStaticMonthForYear', 'watchedTypeUser']));
    }
    return view("404");
  }
}
