<?php

namespace Modules\Product\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Product\Database\Factories\ReviewFactory;

#[Fillable(['user_id', 'product_id', 'rating', 'comment'])]
class Review extends Model
{
    use HasFactory;

    // protected static function newFactory(): ReviewFactory
    // {
    //     // return ReviewFactory::new();
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}