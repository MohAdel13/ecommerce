<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index');
        Route::post('/cart/add', 'add');
        Route::put('/cart/update', 'update');
        Route::delete('/cart/remove', 'remove');
        Route::delete('/cart/clear', 'removeAll');
    });
});