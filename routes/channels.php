<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Modules\Ticket\Models\Ticket;

Broadcast::channel('ticket.{ticket}', function (User $user, Ticket $ticket) {
    Log::info($user);
    return $user->role === Role::Admin
        || $ticket->user_id === $user->id;
});