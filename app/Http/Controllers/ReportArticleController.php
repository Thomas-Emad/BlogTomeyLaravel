<?php

namespace App\Http\Controllers;

use App\Models\ReportArticle;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ReportArticleController extends Controller
{
  public function __invoke($user, $id)
  {
    $report_exisit = ReportArticle::where([['id_article', $id], ['id_user_report', \Auth::user()->id]])->first();
    if ($report_exisit) {
      return back();
    } else {
      // Check If Account Reports 10 All Send report For User [if User Have 3 Report All Block]
      ReportArticle::create([
        'id_article' => $id,
        'id_user_report' => \Auth::user()->id,
      ]);
      $countReportsArticle = ReportArticle::where('id_article', $id)->count();

      if ($countReportsArticle >= 10) {
        // Add One Report For User Then Check All Reports
        $article_reported = Article::where('id', $id)->first();
        $user_article = User::where('id', $article_reported->id_user)->first();
        $user_article->increment('reports', 1);
        $user_article->refresh();
        if ($user_article->reports >= 3) {
          $user_article->update([
            'status' => 'block'
          ]);
        }

        // Hidden This Article Had 10 Reports
        $article_reported->update([
          'hidden' => now()
        ]);
      }

      return back()->with("message", __("messages.reports"));
    }
  }
}
