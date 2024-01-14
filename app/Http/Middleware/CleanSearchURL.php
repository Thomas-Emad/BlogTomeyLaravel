<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CleanSearchURL
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if ($request->is('searchForm')) {
      $type = !empty($request->query('type')) ? $request->query('type') : 'all';
      $title = !empty($request->query('title')) ? $request->query('title') : '';
      $url = '/search/' . $type . '/' . $title;
      return redirect()->to($url);
    }

    return $next($request);
  }
}
