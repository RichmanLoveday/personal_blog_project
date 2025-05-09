<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ArticleTag;
use App\Notifications\ContactNotification;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
            ->orderBy('published_at', 'desc')
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
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        }

        $mostPopularArticles = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->where('views', '>=', 50)
            ->whereNotNull('published_at')
            ->orderBy('views', 'desc')
            ->limit(20)
            ->get();

        // dd($mostPopularArticles);


        $trendingNews = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->where('is_trending', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        $featureNews = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        $recentNews = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
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
            'recentNews',
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
                ->orderBy('published_at', 'desc')
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

        //? recent posts
        $recentPosts = Article::with(['category', 'user', 'tags'])
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->take(4)
            ->get();

        $categories = Category::with(['posts' => function ($query) {
            $query->where('status', 'active')
                ->whereNotNull('published_at');
        }])->where('status', 'active')
            ->get();


        $tags = cache()->remember('active_tags', now()->addMinutes(5), function () {
            return Tag::withWhereHas('articles', function ($query) {
                $query->where('status', 'active')
                    ->whereNotNull('published_at');
            })
                ->where('status', 'active')
                ->inRandomOrder()
                ->take(8)
                ->get();
        });


        if (!$article) abort(404);

        // dd($recentPosts);

        //? update views by incrementation
        Article::where('id', $id)->increment('views');

        //? return view
        return view('blog_detail', compact(
            'article',
            'categories',
            'recentPosts',
            'tags'
        ));
    }

    public function getBlogs()
    {
        //? get all active articles
        $articles = Article::with(['category', 'user', 'tags'])
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        //? recent posts
        $recentPosts = Article::with(['category', 'user', 'tags'])
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->take(4)
            ->get();


        $categories = Category::with(['posts' => function ($query) {
            $query->where('status', 'active')
                ->whereNotNull('published_at');
        }])->where('status', 'active')
            ->get();


        //? get tags randomly
        $tags = cache()->remember('active_tags', now()->addMinutes(5), function () {
            return Tag::withWhereHas('articles', function ($query) {
                $query->where('status', 'active')
                    ->whereNotNull('published_at');
            })
                ->where('status', 'active')
                ->inRandomOrder()
                ->take(8)
                ->get();
        });

        // dd($tags->toArray());

        return view('blogs', compact('articles', 'recentPosts', 'categories', 'tags'));
    }


    public function getBlogsByCategory(string $slug)
    {
        //? search for cateory
        $category = Category::where('slug', $slug)->first();

        // dd($category);
        if (!$category) abort(404);

        //? get category by id in article
        $articles = Article::with(['category', 'user', 'tags'])
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->latest()
            ->paginate(2)
            ->withQueryString();

        //? recent posts
        $recentPosts = Article::with(['category', 'user', 'tags'])
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->take(4)
            ->get();

        $categories = Category::with(['posts' => function ($query) {
            $query->where('status', 'active')
                ->whereNotNull('published_at');
        }])->where('status', 'active')
            ->get();


        return view('blogs', compact('articles', 'recentPosts', 'categories'));
    }

    public function getBlogByTag(string $slug)
    {
        //? search for tag
        $tag = Tag::where('slug', $slug)->first();

        // dd($category);
        if (!$tag) abort(404);

        //? get article ids from article_tag table
        $articleIds = ArticleTag::where('tag_id', $tag->id)
            ->pluck('article_id')
            ->toArray();

        //? get articles by id in article ids
        $articles = Article::with(['category', 'user', 'tags'])
            ->whereIn('id', $articleIds)
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->latest()
            ->paginate(5)
            ->withQueryString();

        // dd($articles);
        //? recent posts
        $recentPosts = Article::with(['category', 'user', 'tags'])
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->take(4)
            ->get();


        $categories = Category::with(['posts' => function ($query) {
            $query->where('status', 'active')
                ->whereNotNull('published_at');
        }])->where('status', 'active')
            ->get();


        //? get tags randomly
        $tags = cache()->remember('active_tags', now()->addMinutes(5), function () {
            return Tag::withWhereHas(['posts' => function ($query) {
                $query->where('status', 'active')
                    ->whereNotNull('published_at');
            }])
                ->where('status', 'active')
                ->inRandomOrder()
                ->take(8) // Randomly select 8 tags
                ->get();
        });

        return view('blogs', compact('articles', 'recentPosts', 'categories', 'tags'));
    }


    public function sendMail(Request $request)
    {
        try {
            //? validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
            ]);

            //? send mail to admin
            $adminEmail = config('mail.admin_email', 'lovedayrichman@yahoo.com');

            //? set notification route
            Notification::route('mail', $adminEmail)
                ->notify(new ContactNotification(
                    $request->name,
                    $request->email,
                    $request->subject,
                    $request->message
                ));

            //? send response
            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function blogs() {}
}