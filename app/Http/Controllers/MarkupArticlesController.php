<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use App\Models\MarkupArticles;
use Illuminate\Http\Request;

class MarkupArticlesController extends Controller
{
  public function index()
  {
    $articles = \Auth::user()->articles_saved()->whereNull('hidden')->orderByDesc('created_at')->paginate(10);
    $pages_link = $articles->onEachSide(5);

    if ($articles->lastPage() < $articles->currentPage()) {
      return view('404');
    }
    return view('pages.favorite', compact(['articles', 'pages_link']));
  }
  public function markUp($user, $id)
  {
    MarkupArticles::create([
      'id_user' => $user,
      'id_article' => $id
    ]);
    return back()->with('message',  __("messages.favorites.add"));
  }
  public function unMark($user, $id)
  {
    MarkupArticles::where([['id_user', $user], ['id_article', $id]])->delete();
    return back()->with('message', __("messages.favorites.delete"));
  }
}
