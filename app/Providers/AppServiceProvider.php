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
        /**
         * Configures the redirection logic for authenticated users based on their roles.
         *
         * This method uses the `RedirectIfAuthenticated::redirectUsing` function to define
         * custom redirection behavior for users after authentication. The redirection is
         * determined by the role of the authenticated user:
         *
         * - If the user's role is 'admin', they are redirected to the admin dashboard.
         * - If the user's role is 'author', they are redirected to the author dashboard.
         * - For all other roles or unauthenticated users, they are redirected to the home page.
         *
         * @param \Illuminate\Http\Request $request The incoming HTTP request instance.
         * @return string The URL to which the user should be redirected.
         */
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


        /**
         * Redirects unauthenticated users to the 'home' route.
         *
         * This method uses the `Authenticate::redirectUsing` function to define
         * a custom redirection logic for unauthenticated requests. If the user
         * is not authenticated (i.e., `$request->user()` returns null), the
         * request will be redirected to the 'home' route.
         *
         * @param \Illuminate\Http\Request $request The incoming HTTP request.
         * @return string|null The URL to redirect to, or null if no redirection is needed.
         */
        Authenticate::redirectUsing(
            function (Request $request) {
                if (!$request->user()) {
                    return route('home');
                }
            }
        );
    }
}