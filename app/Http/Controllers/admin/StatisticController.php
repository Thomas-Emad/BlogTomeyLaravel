<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Reaction;
use App\Models\ReportArticle;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class StatisticController extends Controller
{
  function __construct()
  {
    $this->middleware(['permission:admin-statistics']);
  }
  public function __invoke()
  {
    // Calc Deg For Users this month
    $countUsers =  User::count();
    $usersLastMonth = User::whereBetween('created_at', [now()->startOfMonth()->subMonth(), now()->endOfMonth()->subMonth()])->count();
    $usersThisMonth = User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
    $usersDeg =  round($usersThisMonth - $usersLastMonth) * 100;

    // Calc Deg For Reactions
    $reactionLastMonth = Reaction::where('action', '1')->whereBetween('created_at', [
      now()->startOfMonth(),
      now()->endOfMonth(),
    ])->count();
    $totelReaction = Reaction::where('action', '1')->count();
    $reactionDeg = round($reactionLastMonth / ($totelReaction != 0 ? $totelReaction : 1)) * 100;

    // Get Reaction in Customer Year
    $reactionArticlesYear = function ($start) {
      // Get All Years From Start
      $dates = [];
      for ($i = $start; $i <= now()->format('Y'); $i++) {
        $dates[] = $i;
      }

      // Get Counts For That Years
      $counts = [];
      foreach ($dates as $year) {
        $dateStart = \Carbon\Carbon::createFromDate($year, 1, 1)->startOfDay();
        $dateEnd = \Carbon\Carbon::createFromDate($year, 12, 31)->endOfDay();

        $actionGood = Reaction::where('action', '1')->whereBetween('created_at', [
          $dateStart,
          $dateEnd,
        ])->count();
        $actionBad = Reaction::where('action', '0')->whereBetween('created_at', [
          $dateStart,
          $dateEnd,
        ])->count();
        $action = [
          $actionGood, $actionBad
        ];
        $counts[$year] = $action;
      }
      return $counts;
    };


    // Get Number Watched Articles by Formate
    $human_readable = new \NumberFormatter(
      'en_US',
      \NumberFormatter::PADDING_POSITION
    );
    $watchedArticles = Article::sum('watched');

    // Get Deg Between This Month And Last one Articles
    $articlesTotle = Article::count();
    $articlesMonth = Article::whereBetween('created_at', [
      now()->startOfMonth(),
      now()->endOfMonth(),
    ])->count();
    $articlesDeg = round($articlesMonth / ($articlesTotle != 0 ? $articlesTotle : 1)) * 100;

    // Get Count Reports Articles
    $reports = ReportArticle::count();

    $topUsers = User::withCount('articles')->orderbyDesc("articles_count")->take(10)->get(10);

    return view('pages.admin.statistic', [
      'countUsers' => $countUsers,
      'usersDeg' => $usersDeg,
      'totelReaction' => $totelReaction,
      'reactionDeg' => $reactionDeg,
      'human_readable' => $human_readable,
      'watchedArticles' => $watchedArticles,
      'articlesTotle' => $articlesTotle,
      'articlesDeg' => $articlesDeg,
      'reports' => $reports,
      'topUsers' => $topUsers,
      'reactionArticlesYear' => $reactionArticlesYear,
    ]);
  }
}
