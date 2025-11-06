<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\isAdministrator;
use illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'isAdministrator' => App\Http\Middleware\isAdministrator::class,
            'isResepsionis' => \App\Http\Middleware\IsResepsionis::class,
            'dokter' => \App\Http\Middleware\dokter::class,
            'pemilik' => \App\Http\Middleware\pemilik::class,
            'perawat' => \App\Http\Middleware\perawat::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
