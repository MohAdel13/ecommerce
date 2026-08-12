<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// use Modules\Product\Database\Factories\AttributeValueFactory;

#[Fillable(['attribute_id', 'value_en', 'value_ar'])]
class AttributeValue extends Model
{
    use HasFactory;

    // protected static function newFactory(): AttributeValueFactory
    // {
    //     // return AttributeValueFactory::new();
    // }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_values', 'attribute_value_id', 'product_variant_id')->withTimestamps();
    }
}
