<?php

namespace Modules\Ticket\Models;

use App\Enums\TicketStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Ticket\Database\Factories\TicketFactory;

#[Fillable(['user_id', 'subject', 'status'])]
class Ticket extends Model
{
    use HasFactory;

    // protected static function newFactory(): TicketFactory
    // {
    //     // return TicketFactory::new();
    // }

    protected $casts = [
        'status' => TicketStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'ticket_id', 'id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}