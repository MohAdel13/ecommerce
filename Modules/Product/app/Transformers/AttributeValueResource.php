<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $attribute = $this->attribute ? new AttributeResource($this->attribute) : null;
        return [
            'id' => $this->id,
            'value' => $this->{'value_' . app()->getLocale()} ?? $this->value_en,
            'attribute' => $attribute ?? null,
        ];
    }
}