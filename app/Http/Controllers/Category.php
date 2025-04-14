<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;

class Category extends Controller
{
    public function index()
    {
        //? get all Category
        $categories = ModelsCategory::where('status', 'active')
            ->latest()
            ->get();

        //? get article by the first category provided
        $articles = [];
        if ($categories && $categories->isNotEmpty()) {
            $articles = Article::with(['category', 'user', 'tags'])
                ->where('category_id', $categories->first()->id)
                ->where('status', 'active')
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(4)
                ->withPath(route('category.article', $categories->first()->slug))
                ->withQueryString();
        }

        $popularArticles = Article::with(['category', 'user', 'tags'])
            ->where('created_at', '>=', now()->subWeek())
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(3)
            ->get();
        // dd($article);

        //? get article by the first category provided
        return view('category', compact('categories', 'articles', 'popularArticles'));
    }


    public function getArticleByCategory(string $categorySlug)
    {
        //? search for category
        $category = ModelsCategory::where('slug', $categorySlug)
            ->where('status', 'active')
            ->first();

        if (!$category) abort(404);

        //? get all Categories
        $categories = ModelsCategory::where('status', 'active')
            ->latest()
            ->get();

        //? get articles by category id
        $articles = [];
        if ($categories && $categories->isNotEmpty()) {
            $articles = Article::with(['category', 'user', 'tags'])
                ->where('category_id', $category->id)
                ->where('status', 'active')
                ->whereNotNull('published_at')
                ->latest()
                ->paginate(4)
                ->withPath(route('category.article', $category->slug))
                ->withQueryString();
        }

        return view('category', compact('articles', 'categories'));
    }


    public function getArticleByCategoryId(int|string $id)
    {
        try {
            //? find category by id
            $category = ModelsCategory::findOrFail($id);

            //? find article by category id
            $articles = Article::with(['category', 'user', 'tags'])
                ->where('category_id', $category->id)
                ->where('status', 'active')
                ->whereNotNull('published_at')
                ->latest()
                ->paginate(4)
                ->withPath(route('category.article', $category->slug))
                ->withQueryString();

            return response()->json([
                'status' => 'success',
                'articles' => $articles,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching articles',
            ], 500);
        }
    }
}
