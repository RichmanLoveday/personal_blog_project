<?php

namespace App\Http\Middleware;

use App\Models\Advert;
use App\Models\Article;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalDataMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //? get all most popular articles with views greater than 50
        $popularArticles = Article::with(['category', 'user', 'tags'])
            //->where('created_at', '>=', now()->subWeek())
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        //dd($popularArticles->toArray());

        /**
         * Retrieves all adverts that have placements in the top or footer positions.
         * 
         * This query uses the `Advert` model to filter adverts that are associated 
         * with placements meeting the `topOrFooter` criteria. It also eagerly loads 
         * the related `placements` data that match the same criteria to optimize 
         * database queries and reduce N+1 query issues.
         * 
         * @return \Illuminate\Database\Eloquent\Collection A collection of adverts with their associated placements.
         */
        //? access advert model and get all adverts and placements
        $adverts = Advert::with(['placements'])
            ->where('status', 'active')
            ->get();

        //dd($adverts->toArray());

        //? share adverts with specific view
        view()->composer([
            'index',
            'about',
            'category',
            'blogs',
            'blog_detail',
            'contact',
        ], function ($view) use ($adverts, $popularArticles) {
            $view->with([
                'adverts' => $adverts,
                'popularArticles' => $popularArticles,
                'currentPage' => request()->segment(1),     //? get current page from url
            ]);
        });

        return $next($request);
    }
}