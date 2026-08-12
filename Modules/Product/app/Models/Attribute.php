<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Product\Database\Factories\AttributeFactory;

#[Fillable(['name_en', 'name_ar'])]
class Attribute extends Model
{
    use HasFactory;

    // protected static function newFactory(): AttributeFactory
    // {
    //     // return AttributeFactory::new();
    // }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_id', 'product_id')->withTimestamps();
    }
}