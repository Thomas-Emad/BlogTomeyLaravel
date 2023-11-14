<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Type;
use App\Models\Types_Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.articles.articles');
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
            'bgArticle' => ['required'],
            'content' => ['required', 'min:50'],
        ]);

        // Add Article
        Article::create([
            'title' => $request->title,
            'id_user' => Auth::user()->id,
            'content' => $request->content,
            'bgArticle' => $request->bgArticle,
        ]);

        // Add Tags For This Article
        $id_article = Article::select("id")->latest()->first()->id;
        foreach ($request->id_types as $id) {
            Types_Articles::create([
                'id_article' => $id_article,
                'id_type' => $id,
            ]);
        }

        return back()->with("message", 'Articles have been added successfully..');
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id, $id)
    {
        $article = Article::findOrFail($id);
        $typeIds = $article->types()->pluck('types.id')->toArray();
        $recommend_articles = Article::whereHas('types', function ($query) use ($typeIds) {
            $query->whereIn('types.id', $typeIds); // Get recommend Articles By Type
        })->select('id_user', 'id', 'bgArticle', 'title')->whereNot('id', $id)->limit(4)->get();

        // Watched Article
        $currentUrl = url()->current();
        $key = 'viewed_urls';
        $viewedUrls = Cache::get($key, []);
        if (!in_array($currentUrl, $viewedUrls)) {
            $viewedUrls[] = $currentUrl;
            Cache::put($key, $viewedUrls, 60); // 60 Second
            $article->increment('watched', 1);
        }

        return view("pages.articles.readArticle", compact("article", 'recommend_articles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
