<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
  public function index($name = null)
  {
    $types = Type::get();
    if ($name == null) {
      $articles = Article::whereNull('hidden')->orderByDesc('created_at')->paginate(10);
    } else {
      $articles = Article::whereNull('hidden')->whereHas('types', function ($query) use ($name) {
        $query->where('name', $name);
      })->orderByDesc('created_at')->paginate(10);
    }
    $pages_link = $articles->onEachSide(5);
    if ($pages_link->lastPage() < $pages_link->currentPage()) {
      return view('404');
    }

    // Take Last 10 Searched And Watched Articles For User And Split it
    if (\Auth::user()) {
      $historyTitle = collect(array_merge(\Auth::user()->articles_watched->pluck('title')->take(5)->toArray(), \Auth::user()->search->pluck('content')->take(5)->toArray()))->shuffle();
      $historyTerms = [];
      foreach ($historyTitle as $title) {
        $historyTerms = array_merge($historyTerms, explode(' ', $title));
      }

      // Get All Articles has This Word Search And watched Articles, And Check if That Does not In View Articles
      $results = Article::where(function ($query) use ($historyTerms, $articles) {
        foreach ($historyTerms as $word) {
          $query->orWhere('title', 'LIKE', "%$word%")->whereNotIn('articles.id', $articles->pluck('id'))->select('articles.id', 'articles.id_user', 'articles.title', 'articles.content', 'articles.bgArticle');
        }
      })->whereNotIn('articles.id', $articles->pluck('id'))->whereNull('hidden')->get();

      // order By Top Like it
      $orderResults = $results->sortByDesc(function ($result) use ($historyTitle) {
        foreach ($historyTitle as $search) {
          return similar_text($result->title, $search);
        }
      });
      $recommendArticles = $orderResults->take(10);
    } else {
      $recommendArticles = [];
    }

    return view('index', compact(['types', 'articles', 'pages_link', 'recommendArticles']));
  }
}
