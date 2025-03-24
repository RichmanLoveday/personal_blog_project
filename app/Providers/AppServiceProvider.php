<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RedirectIfAuthenticated::redirectUsing(
            function (Request $request) {
                if ($request->user()?->role === 'admin') {
                    return route('admin.dashboard');
                } elseif ($request->user()?->role === 'author') {
                    return route('author.dashboard');
                }

                return route('home');
            }
        );


        Authenticate::redirectUsing(
            function (Request $request) {
                if (!$request->user()) {
                    return route('home');
                }
            }
        );
    }
}