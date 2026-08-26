<?php

namespace Modules\Order\Models;

use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Address\Models\Address;
use Modules\Payment\Models\Payment;

// use Modules\Order\Database\Factories\OrderFactory;

#[Fillable(['user_id', 'address_id', 'subtotal', 'discount', 'coupon_amount', 'tax', 'total_amount', 'status'])]
class Order extends Model
{
    use HasFactory;

    // protected static function newFactory(): OrderFactory
    // {
    //     // return OrderFactory::new();
    // }

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function OrderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }
}