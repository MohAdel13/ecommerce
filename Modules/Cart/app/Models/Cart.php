<?php

namespace Modules\Cart\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Cart\Database\Factories\CartFactory;

#[Fillable('user_id')]
class Cart extends Model
{
    use HasFactory;

    // protected static function newFactory(): CartFactory
    // {
    //     // return CartFactory::new();
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }

    public function getTotalItemsAttribute(): int
    {
        return $this->cartItems->sum('quantity');
    }

    public function getSubtotalAttribute()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->variant->price;
        });
    }

    // public function getTotalAfterDiscountAttribute(): float
    // {
    //     return $this->cartItems->sum(function ($item) {
    //         return $item->quantity * $item->variant->price_after_discount;
    //     });
    // }

    public function getOutOfStockAttribute(): bool
    {
        return $this->cartItems->contains(function ($item) {
            return $item->variant->stock < $item->quantity;
        });
    }
}