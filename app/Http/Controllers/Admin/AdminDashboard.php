<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function index()
    {
        //? get total numbers of authors
        $authors_count = User::where('role', 'author')->count();

        //? get total numbers of categories
        $categories_count = Category::count();

        //? get total numbers of tags
        $tags_count = Tag::count();

        //? get total numbers of articles
        $articles_count = Article::count();

        return view('admin.dashboard', compact(
            'authors_count',
            'categories_count',
            'tags_count',
            'articles_count'
        ));
    }
}
