<?php

namespace Modules\Banner\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// use Modules\Banner\Database\Factories\BannerFactory;

#[Fillable(['is_external', 'link', 'category_id'])]
class Banner extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // protected static function newFactory(): BannerFactory
    // {
    //     // return BannerFactory::new();
    // }

    protected $casts = [
        'is_external' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('banners') ?? null;
    }
}