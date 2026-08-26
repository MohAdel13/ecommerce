<?php

namespace Modules\Order\Transformers;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $attributes = null;
        if ($this->selected_attributes) {
            $attributes = [];
            foreach ($this->selected_attributes as $key => $value) {
                $attributes[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }
        }

        return [
            'product_name' => $this->{'product_name_' . app()->getLocale()},
            'unit_price' => $this->unit_price,
            'discount' => $this->discount,
            'quantity' => $this->quantity,
            'images' => $this->variant ? MediaResource::collection($this->variant->product?->images) : null,
            'selected_attributes' => $attributes,
        ];
    }
}