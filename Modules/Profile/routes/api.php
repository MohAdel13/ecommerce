<?php

use Illuminate\Support\Facades\Route;
use Modules\Profile\Http\Controllers\ProfileController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'show');
        Route::put('/profile/update', 'update');
        Route::put('/profile/update-password', 'updatePassword');
        Route::delete('/profile/delete', 'delete');
    });
});