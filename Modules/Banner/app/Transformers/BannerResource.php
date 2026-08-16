<?php

namespace Modules\Banner\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\CategoryResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_external' => $this->is_external,
            'link' => $this->link,
            'category' => $this->category ? new CategoryResource($this->category) : null,
            'image' => $this->image,
        ];
    }
}