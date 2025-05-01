<?php

use App\Http\Middleware\Cors;
use App\Http\Middleware\GlobalDataMiddleWare;
use App\Http\Middleware\IsActiveMiddleWare;
use App\Http\Middleware\RoleMiddleWare;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleWare::class,
            'isActive' => IsActiveMiddleWare::class,
            'globalData' => GlobalDataMiddleWare::class,
        ]);

        $middleware->redirectGuestsTo(fn(Request $request) => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();