<?php

use Illuminate\Support\Facades\Route;
use Modules\Tax\Http\Controllers\TaxController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('v1')->group(function () {
    Route::controller(TaxController::class)->group(function () {

        Route::get('/taxes', 'index');
        Route::get('/taxes/{tax}', 'show');

        Route::post('/taxes/create', 'create');
        Route::put('/taxes/update/{tax}', 'update');
        Route::delete('/taxes/delete/{tax}', 'delete');
    });
});