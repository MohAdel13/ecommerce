<?php

namespace Modules\Ticket\Models;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Ticket\Database\Factories\MessageFactory;

#[Fillable(['ticket_id', 'sender_type', 'sender_id', 'message'])]
class Message extends Model
{
    use HasFactory;

    // protected static function newFactory(): MessageFactory
    // {
    //     // return MessageFactory::new();
    // }

    protected $casts = [
        'sender_type' => Role::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}