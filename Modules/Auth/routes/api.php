<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/social-auth', 'socialAuth');
        Route::post('/register', 'register');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/fcm', 'updateFcm');
            Route::post('/logout', 'logout');
        });
    });
});