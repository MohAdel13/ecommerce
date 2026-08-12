<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

Route::prefix('v1')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index');
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->controller(CategoryController::class)->group(function () {
        Route::post('/categories/create', 'create');
        Route::put('/categories/update/{category}', 'update');
        Route::delete('/categories/delete/{category}', 'delete');
        Route::get('/categories/{category}', 'show');
    });
});