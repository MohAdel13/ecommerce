<?php

namespace Modules\Tax\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->{'name_' . app()->getLocale()},
            'rate' => $this->rate,
            'is_active' => $this->is_active
        ];
    }
}