<?php

use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\AddressController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::controller(AddressController::class)->group(function () {
        Route::get('/addresses', 'index');
        Route::post('/addresses/create', 'create');
        Route::put('/addresses/update/{address}', 'update');
        Route::delete('/addresses/delete/{address}', 'delete');
        Route::get('/addresses/{address}', 'show');
    });
});