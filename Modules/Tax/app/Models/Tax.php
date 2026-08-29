<?php

namespace Modules\Tax\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\Models\Product;
use Modules\Tax\Observers\TaxObserver;

// use Modules\Tax\Database\Factories\TaxFactory;

#[Fillable(['name_en', 'name_ar', 'rate', 'is_active'])]
class Tax extends Model
{
    use HasFactory;

    // protected static function newFactory(): TaxFactory
    // {
    //     // return TaxFactory::new();
    // }

    protected static function booted()
    {
        static::observe(new TaxObserver());
    }

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'tax_id', 'id');
    }
}