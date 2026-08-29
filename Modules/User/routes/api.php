<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('v1')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::post('/users/create', 'create');
        Route::get('/users/roles', 'getRoles');
        Route::put('/users/update/{user}', 'update');
        Route::delete('/users/delete/{user}', 'delete');
        Route::get('/users/{user}', 'show');
    });
});