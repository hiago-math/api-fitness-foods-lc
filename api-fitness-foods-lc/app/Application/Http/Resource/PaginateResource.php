<?php

namespace Application\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PaginateResource extends JsonResource
{

    public function toArray($request)
    {
        $products = $this->collectionFormated();
        return [
            'products' => Arr::get($products, 'data', []),
            'current_page' => $this->resource->currentPage(),
            'per_page' => $this->resource->perPage(),
            'last_page' => $this->resource->lastPage(),
            'total' => $this->resource->total(),
        ];
    }

    private function collectionFormated()
    {
        return $this->resource->toArray();
    }
}
