<?php

namespace Modules\Favourite\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Favourite\Observers\FavouriteObserver;
use Modules\Product\Models\Product;

// use Modules\Favourite\Database\Factories\FavouriteFactory;

#[Fillable(['product_id', 'user_id'])]
class Favourite extends Model
{
    use HasFactory;

    // protected static function newFactory(): FavouriteFactory
    // {
    //     // return FavouriteFactory::new();
    // }

    protected static function booted()
    {
        static::observe(new FavouriteObserver());
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}