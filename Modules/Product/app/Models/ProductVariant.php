<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Cart\Models\CartItem;

// use Modules\Product\Database\Factories\ProductVariantFactory;

#[Fillable(['product_id', 'sku', 'price', 'stock', 'is_default'])]
class ProductVariant extends Model
{
    use HasFactory;

    // protected static function newFactory(): ProductVariantFactory
    // {
    //     // return ProductVariantFactory::new();
    // }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attribute_values', 'product_variant_id', 'attribute_value_id')->withTimestamps();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_variant_id', 'id');
    }

    public function priceAfterDiscount()
    {
        $price = (float) $this->price;

        $offer = $this->product->bestOffer();

        if (!$offer) {
            return $price;
        }

        return max(
            0,
            $price - ($price * $offer->discount_value / 100)
        );
    }

    public function discountAmount()
    {
        $offer = $this->product->bestOffer();

        if (!$offer) {
            return 0;
        }

        return (float) $this->price * ($offer->discount_value / 100);
    }
}