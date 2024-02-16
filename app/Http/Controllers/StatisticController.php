<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
  public function __invoke()
  {
    $user = Auth::user();
    // Calc Deg For $followersDeg this month
    $allFollowers = ($user->followers->count() != 0) ? $user->followers->count() : 1;
    $followersDeg =  round($user->followers()->whereBetween('created_at', [now()->startOfMonth()->subMonth(), now()->endOfMonth()->subMonth()])->count() / $allFollowers) * 100;

    // Calc Deg For Reactions
    $reactionLastMonth = $user->articles()->whereHas('ReactionArticles', function ($query) {
      $query->where('action', '1')->whereBetween('created_at', [
        now()->startOfMonth(),
        now()->endOfMonth(),
      ]);
    })->count();
    $totelReaction = $user->articles()->whereHas('ReactionArticles', function ($query) {
      $query->where('action', '1');
    })->count();
    $reactionDeg = round($reactionLastMonth / ($totelReaction != 0 ? $totelReaction : 1)) * 100;

    // Get Reaction in Customer Year
    $reactionArticlesYear = function ($start, $user, $action) {
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

        $actionGood = $user->articles()->whereHas('ReactionArticles', function ($query) use ($dateStart, $dateEnd) {
          $query->where('action', '1')->whereBetween('created_at', [
            $dateStart,
            $dateEnd,
          ]);
        })->count();
        $actionBad = $user->articles()->whereHas('ReactionArticles', function ($query) use ($dateStart, $dateEnd) {
          $query->where('action', '0')->whereBetween('created_at', [
            $dateStart,
            $dateEnd,
          ]);
        })->count();
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
    $watchedArticles = $human_readable->format($user->articles()->sum('watched'));

    // Get Deg Between This Month And Last one Articles
    $articlesTotle = $user->articles()->count();
    $articlesMonth = $user->articles()->whereBetween('created_at', [
      now()->startOfMonth(),
      now()->endOfMonth(),
    ])->count();
    $articlesDeg = round($articlesMonth / ($articlesTotle != 0 ? $articlesTotle : 1)) * 100;

    // Get Comments
    $comments =  Comment::whereIn('id_post', $user->articles()->pluck('id'))->get();
    // return $comments;

    return view('pages.statistic', ['user' => $user, 'allFollowers' => $allFollowers, 'followersDeg' => $followersDeg, 'totelReaction' => $totelReaction, 'reactionDeg' => $reactionDeg, 'followersDeg' => $followersDeg, 'watchedArticles' => $watchedArticles, 'articlesTotle' => $articlesTotle, 'articlesDeg' => $articlesDeg, 'reactionArticlesYear' => $reactionArticlesYear, 'comments' => $comments]);
  }
}
