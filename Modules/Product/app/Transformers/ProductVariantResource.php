<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => $this->price,
            // 'discount' => $this->product->offer,
            // 'price_after_discount' => $this->price_after_discount,
            'stock' => $this->stock,
            'attributes' => $this->attributeValues ? AttributeValueResource::collection($this->attributeValues) : null,
        ];
    }
}