<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}