<?php

namespace Modules\Address\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address_name' => $this->address_name,
            'address_line' => $this->address_line,
            'phone' => $this->phone,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'note' => $this->note,
            'is_default' => $this->is_default
        ];
    }
}