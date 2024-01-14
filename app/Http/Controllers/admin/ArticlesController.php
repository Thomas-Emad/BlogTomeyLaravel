<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

  public function index($title = null)
  {
    $articles = Article::where('title', 'Like', "%$title%")->withCount("reports")->orderByDesc("reports_count")->limit(100)->get();
    return view('pages.admin.articles', compact("articles"));
  }

  public function statusArticle($id_user, $id)
  {
    $article = Article::where([['id_user', $id_user], ['id', $id]])->firstOrFail();
    if ($article->hidden == null) {
      $article->update([
        'hidden' => now(),
      ]);
    } else {
      $article->update([
        'hidden' => null,
      ]);
    }

    return back()->with("message", __("messages.articles.banned"));
  }
}
