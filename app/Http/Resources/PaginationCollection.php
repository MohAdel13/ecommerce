<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    protected $resourceClass = null;
    protected $name = null;
    public function __construct($resource, $name, $resourceClass)
    {
        parent::__construct($resource);
        $this->resourceClass = $resourceClass;
        $this->name = $name;
    }

    public function toArray(Request $request): array
    {
        return [
            $this->name => $this->collection->map(function ($item) {
                return $this->resourceClass
                    ? new $this->resourceClass($item)
                    : $item;
            }),
            'meta' => [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'total' => $this->resource->total(),
            ],
        ];
    }
}