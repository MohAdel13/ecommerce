<?php

namespace Modules\Address\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Address\Database\Factories\AddressFactory;

#[Fillable(['user_id', 'name', 'address_line', 'phone', 'lat', 'lng', 'is_default', 'note', 'address_name'])]
class Address extends Model
{
    use HasFactory;

    // protected static function newFactory(): AddressFactory
    // {
    //     // return AddressFactory::new();
    // }

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}