<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    protected array $pricing;

    public function __construct($resource, array $pricing = [])
    {
        parent::__construct($resource);

        $this->pricing = $pricing;
    }
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->cartItems),
            'out_of_stock' => $this->out_of_stock,
            'subtotal' => $this->subtotal,
            'discount' => $this->pricing['discount'],
            'coupon_discount' => $this->pricing['coupon_discount'],
            'tax' => $this->pricing['tax_amount'],
            'total' => $this->pricing['total'],
        ];
    }
}