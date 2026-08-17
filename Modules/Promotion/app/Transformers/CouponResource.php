<?php

namespace Modules\Promotion\Transformers;

use App\Http\Resources\EnumResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->discount_type ? new EnumResource($this->discount_type) : null,
            'value' => $this->discount_value,
            'usage_per_user' => $this->usage_per_user,
            'usage_limit' => $this->usage_limit,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
        ];
    }
}