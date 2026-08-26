<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\OrderController;

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->controller(OrderController::class)->group(function () {
        Route::get('orders/my-orders', 'myOrders');
        Route::get('orders/statuses', 'statuses');
        Route::post('orders/create', 'create');
        Route::put('orders/cancel/{order}', 'cancel');
        Route::get('orders/{order}', 'show');
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->controller(OrderController::class)->group(function () {
        Route::get('orders', 'index');
        Route::put('orders/update/{order}', 'update');
        Route::delete('orders/delete/{order}', 'delete');
    });
});