<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActiveMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //? check if user's status is active 
        if (Auth::check() && Auth::user()->status != 'active') {
            Auth::logout();
            return redirect()->route('author.login')
                ->withErrors(['email' => 'Your account has been deactivated, Please contact admin!']);
        }

        return $next($request);
    }
}
