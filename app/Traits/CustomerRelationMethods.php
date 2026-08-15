<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Cart\Models\Cart;

trait CustomerRelationMethods
{
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'user_id', 'id');
    }
}