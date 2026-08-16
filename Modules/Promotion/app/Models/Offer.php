<?php

namespace Modules\Promotion\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Product\Models\Product;

// use Modules\Promotion\Database\Factories\OfferFactory;

#[Fillable(['code', 'discount_value', 'starts_at', 'ends_at', 'is_active'])]
class Offer extends Model
{
    use HasFactory;

    // protected static function newFactory(): OfferFactory
    // {
    //     // return OfferFactory::new();
    // }

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_offers', 'offer_id', 'product_id')->withTimestamps();
    }
}