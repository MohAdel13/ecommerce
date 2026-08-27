<?php

use App\Exceptions\BusinessException;
use App\Exceptions\ErrorHandling;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\GetLocale;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__ . '/../routes/channels.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withBroadcasting(
        channels: __DIR__ . '/../routes/channels.php',
        attributes: [
            'middleware' => ['auth:sanctum'],
        ],
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            GetLocale::class,
        ]);

        $middleware->alias([
            'role' => CheckRole::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AuthenticationException $e) {

            if (request()->expectsJson() || request()->is('api/*')) {

                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'Unauthorized',
                ], 401);
            }

            return null;
        });

        $exceptions->render(function (AccessDeniedHttpException $e) {

            if (request()->expectsJson() || request()->is('api/*')) {

                return response()->json([
                    'message' => 'Forbidden',
                    'error' => 'Forbidden',
                ], 403);
            }

            return null;
        });

        $exceptions->render(function (NotFoundHttpException $e) {

            if (request()->expectsJson() || request()->is('api/*')) {

                return response()->json([
                    'message' => 'Not Found',
                    'error' => 'Not Found',
                ], 404);
            }

            return null;
        });

        $exceptions->render(function (BusinessException $e) {
            $request = request();

            if ($request->expectsJson() || $request->is('api/*')) {
                return app(ErrorHandling::class)
                    ->buisnessErrorHandle($e);
            }

            return null;
        });

        $exceptions->render(function (Throwable $e) {
            $request = request();

            if ($request->expectsJson() || $request->is('api/*')) {
                return app(ErrorHandling::class)
                    ->unexpectedErrorHandle($e);
            }

            return null;
        });

        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );
    })->create();