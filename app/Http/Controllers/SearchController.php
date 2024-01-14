<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Type;
use Illuminate\Http\Request;


class SearchController extends Controller
{
  public function index($type = 'all', $title = null)
  {
    $lastSearched = [];

    // Get Date By Values And Calc Time Search
    $start_time = microtime(true);
    $type = ($type == 'all') ? 'all' : $type;
    if ($type == 'all' && $title == null) {
      $articles = Article::searchArticles();
    } elseif ($type == 'all' && $title != null) {
      $articles = Article::where('title', 'like', "%{$title}%")->searchArticles();
    } elseif ($type != 'all' && $title == null) {
      $articles = Article::whereHas('types', function ($query) use ($type) {
        $query->where('name', $type);
      })->searchArticles();
    } elseif ($type != 'all' && $title != null) {
      $articles = Article::where('title', 'like', "%{$title}%")->whereHas('types', function ($query) use ($type) {
        $query->where('name', $type);
      })->searchArticles();
    }
    $end_time = microtime(true);

    // Take Time Query And Get Articles
    $requestTime = $end_time - $start_time;
    $types = Type::all();

    // Paginate
    $pages_link = $articles->onEachSide(5);
    if ($pages_link->lastPage() < $pages_link->currentPage()) {
      return view('404');
    }


    if (\Auth::user()) {
      // Get Last 20 Searched for this User
      $lastSearched = \Auth::user()->search->whereNull('hidden')->sortByDesc('created_at')->take(20);

      // Save This Search IF User Auth in Blog
      \Auth::user()->search()->updateOrCreate([
        'id_user' => \Auth::user()->id,
        'content' => $title,
        'type' => $type,
      ],
        [
          'id_user' => \Auth::user()->id,
          'content' => $title,
          'type' => $type,
        ]);
    }

    return view('pages.search', [
      'type' => $type,
      'title' => $title,
      'articles' => $articles,
      'types' => $types,
      'requestTime' => $requestTime,
      'pages_link' => $pages_link,
      'lastSearched' => $lastSearched
    ]);
  }
}
