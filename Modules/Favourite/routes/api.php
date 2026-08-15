<?php

use Illuminate\Support\Facades\Route;
use Modules\Favourite\Http\Controllers\FavouriteController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::controller(FavouriteController::class)->group(function () {
        Route::get('/favourites', 'index');
        Route::post('/favourites/modify', 'modify');
    });
});