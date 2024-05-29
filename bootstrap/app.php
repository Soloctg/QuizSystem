<?php

use App\Http\Middleware\isAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        //'isAdmin' => \App\Http\Middleware\isAdmin::class,
        //\Illuminate\Foundation\Http\Middleware\isAdmin::class,
        $middleware->append(isAdmin::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
