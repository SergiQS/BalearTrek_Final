<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },

        // web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        // commands: __DIR__.'/../routes/console.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'CHECK-ROLEADMIN' => \App\Http\Middleware\CheckRoleAdmin::class,
            'API-KEY' => \App\Http\Middleware\ApiKeyMiddleware::class,  // 'API-KEY' és l'alias del middleware
            'multiauth' => \App\Http\Middleware\MultiAuthMiddleware::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,


        ]);

        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);



        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
