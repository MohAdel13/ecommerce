<?php

use Illuminate\Support\Facades\Route;
use Modules\Ticket\Http\Controllers\MessageController;
use Modules\Ticket\Http\Controllers\TicketController;

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(TicketController::class)->group(function () {
            Route::get('/tickets/my-tickets', 'myTickets');
            Route::post('/tickets/create', 'create');
            Route::delete('/tickets/delete/{ticket}', 'delete');
            Route::get('/tickets/{ticket}', 'show');
        });

        Route::controller(MessageController::class)->group(function () {
            Route::get('/messages', 'index');
            Route::post('/messages/create', 'create');
        });
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::controller(TicketController::class)->group(function () {
            Route::get('/tickets', 'index');
            Route::put('/tickets/update/{ticket}', 'update');
        });

        Route::controller(MessageController::class)->group(function () {
            Route::delete('/messages/delete/{message}', 'delete');
        });
    });
});