<?php

namespace App\Application\Http\Resource\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class GetProductByCodeResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'product' => $this->resource->toArray()
        ];
    }
}
