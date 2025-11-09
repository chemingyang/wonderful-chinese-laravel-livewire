<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            //'ensureUserType' => \App\Http\Middleware\EnsureUserType::class, // Alias for route middleware
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            //'convert_empty_string_to null' => \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, $request) {
            if ($e instanceof AccessDeniedHttpException || 
                ($e instanceof HttpException && $e->getStatusCode() === 403)) {
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'You are not authorized to access this resource.'
                    ], 403);
                }

                return redirect()->route('dashboard')
                    ->with('error', 'You are not authorized to access that page.');
            }
        });
    })->create();
