<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
  public function index($page)
  {
    if (view()->exists($page)) {
      return view($page);
    } else {
      return view('404');
    }
  }
}
