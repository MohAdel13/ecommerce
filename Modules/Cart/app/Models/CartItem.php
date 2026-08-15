<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Models\ProductVariant;

// use Modules\Cart\Database\Factories\CartItemFactory;

#[Fillable(['cart_id', 'product_variant_id', 'quantity'])]
class CartItem extends Model
{
    use HasFactory;

    // protected static function newFactory(): CartItemFactory
    // {
    //     // return CartItemFactory::new();
    // }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }
}
