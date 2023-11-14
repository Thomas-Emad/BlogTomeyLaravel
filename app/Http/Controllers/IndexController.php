<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $types = Type::get();
        $articles = Article::orderByDesc('created_at')->paginate(10);
        $pages_link = $articles->onEachSide(5);
        if ($pages_link->lastPage() < $pages_link->currentPage()) {
            return view('404');
        }
        return view('index', compact(['types', 'articles', 'pages_link']));
    }

}
