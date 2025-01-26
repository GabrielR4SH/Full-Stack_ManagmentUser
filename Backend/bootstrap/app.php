<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\Authenticate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;


//TODO:
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware for handling API requests
        $middleware->add(Authenticate::class); // Ensures users are authenticated
        $middleware->add(ThrottleRequests::class); // Throttle requests to avoid abuse
        $middleware->add(ValidateSignature::class); // Validates signed URLs

        // Additional global middleware can be added here
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handles 404 exceptions for API routes
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not Found'
                ], 404);
            }
        });

        // Handle other exceptions globally
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ], $e->getCode() ?: 500);
            }
        });
    })
    ->create();
