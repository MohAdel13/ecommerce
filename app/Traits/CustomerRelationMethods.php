<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Address\Models\Address;
use Modules\Cart\Models\Cart;
use Modules\Favourite\Models\Favourite;
use Modules\Order\Models\Order;
use Modules\Promotion\Models\Coupon;
use Modules\Ticket\Models\Ticket;

trait CustomerRelationMethods
{
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'user_id', 'id');
    }

    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class, 'user_id', 'id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'user_coupons', 'user_id', 'coupon_id')->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id', 'id');
    }
}