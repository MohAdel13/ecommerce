<?php

namespace Modules\Payment\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Order;

// use Modules\Payment\Database\Factories\PaymentFactory;

#[Fillable(['order_id', 'transaction_id', 'payment_method', 'status', 'amount', 'paid_at', 'reference'])]
class Payment extends Model
{
    use HasFactory;

    // protected static function newFactory(): PaymentFactory
    // {
    //     // return PaymentFactory::new();
    // }

    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'status' => PaymentStatus::class,
        'reference' => 'array'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}