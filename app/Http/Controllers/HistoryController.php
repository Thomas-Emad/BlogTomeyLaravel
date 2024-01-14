<?php

namespace App\Http\Controllers;

use App\Models\WatchedArticles;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
  public function index()
  {
    $articles = \Auth::user()->articles_watched()->whereNull('articles.hidden')->orderByDesc('created_at')->paginate(10);
    $pages_link = $articles->onEachSide(5);
    if ($articles->lastPage() < $articles->currentPage()) {
      return view('404');
    }
    return view("pages.history", compact(['articles', 'pages_link']));
  }

  public function hidden($id_user, $id)
  {
    $article = WatchedArticles::where('id_user', $id_user)->where('id_article', $id);
    $article->update([
      'hidden' => now()
    ]);
    return back()->with('message', __("messages.history.hidden"));
  }
}
