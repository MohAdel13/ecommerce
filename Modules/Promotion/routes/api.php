<?php

use Illuminate\Support\Facades\Route;
use Modules\Promotion\Http\Controllers\CouponController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {

    Route::middleware('auth:sanctum')->controller(CouponController::class)->group(function () {
        Route::post('/coupons/validate', 'validateCoupon');
        Route::get('/coupons/types', 'couponTypes');
    });

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::controller(CouponController::class)->group(function () {
            Route::get('/coupons', 'index');
            Route::post('/coupons', 'create');
            Route::put('/coupons/{coupon}', 'update');
            Route::delete('/coupons/{coupon}', 'delete');
        });
    });
});