<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorDashboard extends Controller
{
    public function index()
    {
        //? get total numbers of articles
        $articles_count = Article::where('user_id', Auth::user()->id)
            ->count();

        return view('author.dashboard', compact(
            'articles_count'
        ));
    }
}
