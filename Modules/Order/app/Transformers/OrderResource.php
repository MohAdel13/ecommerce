<?php

namespace Modules\Order\Transformers;

use App\Http\Resources\EnumResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Address\Transformers\AddressResource;
use Modules\Payment\Transformers\PaymentResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address ? new AddressResource($this->address) : null,
            'date' => $this->created_at,
            'status' => new EnumResource($this->status),
            'payment_method' => $this->payment ? new EnumResource($this->payment->payment_method) : null,
            'items' => $this->orderItems ? OrderItemResource::collection($this->orderItems) : null,
            'payment' => $this->payment ? new PaymentResource($this->payment) : null,
        ];
    }
}