<?php

namespace Modules\Notification\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

// use Modules\Notification\Database\Factories\NotificationFactory;

#[Fillable(['user_id', 'title', 'body', 'is_read', 'notifiable_type', 'notifiable_id'])]
class Notification extends Model
{
    use HasFactory;

    // protected static function newFactory(): NotificationFactory
    // {
    //     // return NotificationFactory::new();
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}