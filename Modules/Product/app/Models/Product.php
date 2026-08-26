<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Category\Models\Category;
use Modules\Favourite\Models\Favourite;
use Modules\Order\Models\OrderItem;
use Modules\Promotion\Models\Offer;
use Modules\Tax\Models\Tax;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// use Modules\Product\Database\Factories\ProductFactory;

#[Fillable(['name_en', 'name_ar', 'description_en', 'description_ar', 'features', 'tax_id'])]
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // protected static function newFactory(): ProductFactory
    // {
    //     // return ProductFactory::new();
    // }

    protected $casts = [
        'features' => 'array'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id')->withTimestamps();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id')->where('is_default', false);
    }

    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class, 'product_id', 'id')->where('is_default', true);
    }

    public function getImagesAttribute()
    {
        return $this->getMedia('products');
    }

    public function getHasVariantsAttribute(): bool
    {
        return $this->variants()->exists();
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id', 'attribute_id')->withTimestamps();
    }

    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class, 'product_id', 'id');
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'product_offers', 'product_id', 'offer_id')->withTimestamps();
    }

    public function bestOffer(): ?Offer
    {
        return $this->offers()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->orderByDesc('discount_value')
            ->orderByDesc('created_at')
            ->first();
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class, 'tax_id', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}