<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\NotificationController;

Route::middleware(['auth:sanctum'])->controller(NotificationController::class)->prefix('v1')->group(function () {
    Route::get('/notifications/my-notifications', 'myNotifications');
    Route::put('/notifications/read', 'markAsRead');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/notifications/', 'index');
        Route::post('/notifications/send', 'sendNotification');
        Route::post('/notifications/broadcast', 'broadcastNotification');
    });
});