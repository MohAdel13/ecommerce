<?php

namespace Modules\Product\Transformers;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Promotion\Transformers\OfferResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $user = $request->user('sanctum');

        $is_favourite = $user ? $this->favourites->contains('user_id', $user->id) : false;

        $defaultVariant = $this->defaultVariant;
        return [
            'id' => $this->id,
            'name' => $this->{'name_' . app()->getLocale()},
            'description' => $this->{'description_' . app()->getLocale()},
            'price' => (float) $defaultVariant->price,
            'discount' => $defaultVariant->discountAmount(),
            'price_after_discount' => $defaultVariant->priceAfterDiscount(),
            'stock' => (int) $defaultVariant->stock,
            'sku' => $defaultVariant->sku,
            'is_favourite' => $is_favourite,
            'average_rating' => $this->average_rating,
            'reviews_count' => $this->reviews_count,
            'images' => $this->images ? MediaResource::collection($this->images) : null,
            'features' => collect($this->features)->map(function ($feature) {
                return [
                    'title' => $feature['title_' . app()->getLocale()],
                    'description' => $feature['description_' . app()->getLocale()],
                ];
            }),
            'variants' => $this->variants ? ProductVariantResource::collection($this->variants) : null,
            'offers' => $this->offers ? OfferResource::collection($this->offers) : null
        ];
    }
}