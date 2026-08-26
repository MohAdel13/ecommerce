<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductVariantController;

Route::prefix('v1')->group(function () {

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/products/{product}', 'show');
    });

    Route::middleware(['auth:sanctum'])->controller(ProductController::class)->group(function () {
        Route::post('/products/review/{product}', 'review');
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->controller(ProductController::class)->group(function () {
        Route::post('/products/create', 'create');
        Route::put('/products/update/{product}', 'update');
        Route::delete('/products/delete/{product}', 'delete');

        Route::put('/products/sync-offers/{product}', 'syncOffers');
        Route::put('/products/sync-categories/{product}', 'syncCategories');
        Route::post('/products/add-variants/{product}', 'addVariants');
        Route::post('/products/update-tax/{product}', 'updateTax');
    });


    Route::middleware(['auth:sanctum', 'role:admin'])->controller(ProductVariantController::class)->group(function () {
        Route::get('/product-variants/{variant}', 'show');
        Route::put('/product-variants/update/{variant}', 'update');
        Route::delete('/product-variants/delete/{variant}', 'delete');
    });
});