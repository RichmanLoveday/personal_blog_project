<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class FrontendController extends Controller
{
    public function index()
    {
        //? get active slidders
        $sliders = Article::with(['category', 'user', 'tags'])
            ->where('is_slider', true)
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->latest()
            ->get();

        //? get two latest banners
        $bannerRightTop = Article::with(['category', 'user', 'tags'])
            ->where('is_banner_right_top', true)
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->latest()
            ->first();

        $bannerRightBottom = Article::with(['category', 'user', 'tags'])
            ->where('is_banner_right_bottom', true)
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->latest()
            ->first();


        //? All categories
        $categories = Category::where('status', 'active')
            ->latest()
            ->get();

        $activeArticle = [];
        //? check if categories is empty
        if (!empty($categories)) {
            //? get all active articles, limit to 5
            $activeArticle = Article::with(['category', 'user', 'tags'])
                ->where('status', 'active')
                ->where('category_id', $categories->first()->id)
                ->whereNotNull('published_at')
                ->latest()
                ->limit(5)
                ->get();
        }


        $mostPopularArticles = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->where('views', 1)
            ->whereNotNull('published_at')
            ->latest()
            ->limit(20)
            ->get();


        $trendingNews = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->where('is_trending', true)
            ->whereNotNull('published_at')
            ->latest()
            ->get();

        $featureNews = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->latest()
            ->get();

        $recentNews = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->latest()
            ->limit(3)
            ->get();


        //  dd($bannerRightBottom);

        return view('index', compact(
            'sliders',
            'bannerRightTop',
            'bannerRightBottom',
            'categories',
            'activeArticle',
            'mostPopularArticles',
            'trendingNews',
            'featureNews',
            'recentNews'
        ));
    }


    public function getArticlesByCategory(string|int $categoryId)
    {
        try {
            $activeCategory = Category::where('id', $categoryId)->where('status', 'active');

            if (!$activeCategory) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'category is not active',
                ]);
            }

            //? Fetch active articles within the given category
            $articles = Article::with(['category', 'user', 'tags'])
                ->where('category_id', $categoryId)
                ->where('status', 'active')
                ->whereNotNull('published_at')
                ->latest()
                ->limit(5)
                ->get();

            return response()->json([
                'status' => 'success',
                'articles' => $articles,
                'message' => 'Articles retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred on the server',
                'status' => 'error',
            ], 500);
        }
    }

    public function showBlog(string $slug)
    {
        $slugArr = explode('-', $slug);
        $id = (int) $slugArr[count($slugArr) - 1];        //? get id

        //? remove last index
        array_pop($slugArr);
        $slug = implode('-', $slugArr);


        //? check if article exist
        $article = Article::with(['category', 'user', 'tags'])
            ->where('id', $id)
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('status', 'active')
            ->first();

        $categories = Category::with(['posts' => function ($query) {
            $query->where('status', 'active')
                ->whereNotNull('published_at');
        }])
            ->where('status', 'active')
            ->get();

        if (!$article) abort(404);

        //  dd($article);

        //? update views by incrementation
        Article::where('id', $id)
            ->increment('views');

        //? return view
        return view('blog_detail', compact('article', 'categories'));
    }

    public function about() {}

    public function blogs() {}
}
