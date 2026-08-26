<?php

namespace Modules\Cart\Transformers;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Modules\Product\Transformers\SelectedAttributesResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $variant = $this->variant;
        $product = $variant->product;

        return [
            'id' => $product->id,
            'name' => $product->{'name_' . app()->getLocale()},
            'description' => $product->{'description_' . app()->getLocale()},
            'price' => (float) $variant->price,
            'discount' => $variant->discountAmount(),
            'price_after_discount' => $variant->priceAfterDiscount(),
            'stock' => (int) $variant->stock,
            'sku' => $variant->sku,
            'is_favourite' => false,
            'average_rating' => $this->average_rating,
            'reviews_count' => $this->reviews_count,
            'quantity' => $this->quantity,
            'images' => $product->images ? MediaResource::collection($product->images) : null,
            'has_variants' => $product->has_variants,
            'selected_attributes' => $variant->attributeValues ? SelectedAttributesResource::collection($variant->attributeValues) : null,
        ];
    }
}