<?php

namespace Modules\Payment\Transformers;

use App\Http\Resources\EnumResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'order_id' => $this->order_id,
            'payment_method' => $this->payment_method,
            'amount' => $this->amount,
            'paid_at' => $this->paid_at,
            'reference' => $this->reference,
            'status' => new EnumResource($this->status)
        ];
    }
}