<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        // FIX CSRF: Este middleware es IMPRESCINDIBLE para que Sanctum funcione en modo SPA (stateful).
        // Sin él, Laravel no vincula la sesión a las peticiones del frontend,
        // y la cookie XSRF-TOKEN que recibe React nunca se valida en el backend.
        $middleware->web(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        
        // Aplicar middleware específic per a API: "app/Providers/RouteServiceProvider.php"
        $middleware->api("throttle:api");  // aplica "rate limiting"




        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
          $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'No hem trobat elements.'
                ], 404);
            }
             });
    })->create();
