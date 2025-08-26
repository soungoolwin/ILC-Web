<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MentorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\LecturerMiddleware;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
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
        $middleware->append(RedirectIfAuthenticated::class);
        $middleware->append(MentorMiddleware::class);
        $middleware->append(StudentMiddleware::class);
        $middleware->append(AdminMiddleware::class);
        $middleware->append(LecturerMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
