<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Banner\Models\Banner;
use Modules\Product\Models\Product;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// use Modules\Category\Database\Factories\CategoryFactory;

#[Fillable(['name_en', 'name_ar', 'parent_id'])]
class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // protected static function newFactory(): CategoryFactory
    // {
    //     // return CategoryFactory::new();
    // }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('categories') ?? null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_products', 'category_id', 'product_id')->withTimestamps();
    }

    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class, 'category_id', 'id');
    }
}