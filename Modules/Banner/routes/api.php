<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\BannerController;

Route::prefix('v1')->group(function () {
    Route::controller(BannerController::class)->group(function () {
        Route::get('/banners', 'index');
        Route::get('/banners/{banner}', 'show');
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->controller(BannerController::class)->group(function () {
        Route::post('/banners/create', 'create');
        Route::put('/banners/update/{banner}', 'update');
        Route::delete('/banners/delete/{banner}', 'delete');
    });
});