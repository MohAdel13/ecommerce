<?php

use Illuminate\Support\Facades\Route;
use Modules\Promotion\Http\Controllers\CouponController;
use Modules\Promotion\Http\Controllers\OfferController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {

    Route::middleware('auth:sanctum')->controller(CouponController::class)->group(function () {
        Route::post('/coupons/validate', 'validateCoupon');
        Route::get('/coupons/types', 'couponTypes');
    });

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::controller(CouponController::class)->group(function () {
            Route::get('/coupons', 'index');
            Route::post('/coupons/create', 'create');
            Route::put('/coupons/update/{coupon}', 'update');
            Route::delete('/coupons/delete/{coupon}', 'delete');
            Route::get('/coupons/{coupon}', 'show');
        });

        Route::controller(OfferController::class)->group(function () {
            Route::get('/offers', 'index');
            Route::post('/offers/create', 'create');
            Route::put('/offers/update/{offer}', 'update');
            Route::delete('/offers/delete/{offer}', 'delete');
            Route::get('/offers/{offer}', 'show');
        });
    });
});