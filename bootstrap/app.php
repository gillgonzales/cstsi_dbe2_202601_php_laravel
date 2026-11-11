<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

         // Permite que o Laravel entenda os IPs rotativos do Heroku
        // $middleware->trustProxies(at: '*');
        $middleware->api(prepend:[ForceJsonResponse::class]);
        // dd($middleware->getMiddlewareGroups());
        $middleware->statefulApi();
        $middleware->alias([
            'ability'=>CheckForAnyAbility::class
        ]);
        // dd($middleware->getMiddlewareGroups());
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
