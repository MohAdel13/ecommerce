<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Observers\OrderObserver;
use Modules\Product\Models\ProductVariant;

// use Modules\Order\Database\Factories\OrderItemFactory;

#[Fillable([
    'order_id',
    'product_variant_id',
    'product_name_en',
    'product_name_ar',
    'product_variant_sku',
    'quantity',
    'unit_price',
    'discount',
    'subtotal',
    'selected_attributes'
])]
class OrderItem extends Model
{
    use HasFactory;

    // protected static function newFactory(): OrderItemFactory
    // {
    //     // return OrderItemFactory::new();
    // }

    protected static function booted()
    {
        static::observe(new OrderObserver());
    }

    protected $casts = [
        'selected_attributes' => 'array'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
}