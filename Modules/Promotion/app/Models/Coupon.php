<?php

namespace Modules\Promotion\Models;

use App\Enums\DiscountType;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// use Modules\Promotion\Database\Factories\CouponFactory;

#[Fillable(['code', 'discount_value', 'discount_type', 'starts_at', 'ends_at', 'is_active', 'usage_limit', 'usage_per_user'])]
class Coupon extends Model
{
    use HasFactory;

    // protected static function newFactory(): CouponFactory
    // {
    //     // return CouponFactory::new();
    // }

    protected $casts = [
        'discount_type' => DiscountType::class,
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_coupons', 'coupon_id', 'user_id')->withTimestamps();
    }
}