<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SelectedAttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->attribute->{"name_" . app()->getLocale()},
            'value' => $this->{"value_" . app()->getLocale()},
        ];
    }
}