<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware role kita
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Karena kita pakai Breeze BLADE (bukan Inertia/Vue),
        // HAPUS HandleInertiaRequests supaya tidak error
        $middleware->web(append: [
            // \App\Http\Middleware\HandleInertiaRequests::class,  ← HAPUS / COMMENT
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        App\Providers\HelperServiceProvider::class,
    ])
    ->create();
