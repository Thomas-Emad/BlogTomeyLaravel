<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Type;
use App\Models\User;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index($typeArticles = null)
  {
    $userOpen = \Auth::user();

    // Get Author Articles's You Followed, Filter By TypeArticles
    $types = Type::get();
    $idAuthorFollow = $userOpen->follow->pluck('id_author');
    $youFollow = User::whereIn('id', $idAuthorFollow)->select('id', 'name', 'img')->get();

    if ($typeArticles == null) {
      $articles = Article::whereIn('id_user', $idAuthorFollow)->whereNull('hidden')->select('articles.id', 'articles.id_user', 'articles.title', 'articles.content', 'articles.bgArticle')->orderByDesc("watched")->orderByDesc('created_at')->paginate(10);
    } else {
      $articles = Article::whereIn('id_user', $idAuthorFollow)->whereNull('hidden')->whereHas('types', function ($query) use ($typeArticles) {
        $query->where('name', $typeArticles);
      })->select('articles.id', 'articles.id_user', 'articles.title', 'articles.content', 'articles.bgArticle')->orderByDesc("watched")->orderByDesc('created_at')->paginate(10);
    }
    $pages_link = $articles->onEachSide(5);
    if ($pages_link->lastPage() < $pages_link->currentPage()) {
      return view('404');
    }

    ## Get Recommend Articles By Your Seach And Watched Articles
    // Take Last 10 Searched And Watched Articles For User And Split it
    $historyTitle = collect(array_merge($userOpen->articles_watched->pluck('title')->take(5)->toArray(), $userOpen->search->pluck('content')->take(5)->toArray()))->shuffle();
    $historyTerms = [];
    foreach ($historyTitle as $title) {
      $words = explode(' ', $title);
      $historyTerms = array_merge($historyTerms, explode(' ', $title));
      $badWords = ['is', 'the', 'a', 'his', 'her'];
      foreach ($badWords as $w) {
        if (array_search($w, $words)) {
          unset($words[array_search($w, $words)]);
        }
      }
    }

    // Get All Articles has This Word Search And watched Articles, And Check if That Does not In View Articles
    $results = Article::where(function ($query) use ($historyTerms, $articles) {
      foreach ($historyTerms as $word) {
        $query->orWhere('title', 'LIKE', "%$word%")->whereNotIn('articles.id', $articles->pluck('id'))->select('articles.id', 'articles.id_user', 'articles.title', 'articles.content', 'articles.bgArticle');
      }
    })->whereNull('hidden')->get();

    // order By Top Like it
    $orderResults = $results->sortByDesc(function ($result) use ($historyTitle) {
      foreach ($historyTitle as $search) {
        return similar_text($result->title, $search);
      }
    });
    $recommendArticles = $orderResults->take(10);
    $end = microtime(true);

    return view('home', compact('youFollow', 'types', 'articles', 'pages_link', 'recommendArticles'));
  }
}
