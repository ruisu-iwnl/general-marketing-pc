<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAuth::class,
            'manager' => \App\Http\Middleware\ManagerAuth::class,
        ]);

        // CSRF 예외 (인증 없는 API)
        $middleware->validateCsrfTokens(except: [
            'api/cta-click',
        ]);

        // 방문자 트래킹 미들웨어 (웹 전체)
        $middleware->web(append: [
            \App\Http\Middleware\TrackPageView::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
