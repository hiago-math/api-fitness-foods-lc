<?php

namespace Application\Http\Resource\Errors;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class GetErrorsElasticsearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'errors' => $this->formatedtHits()
        ];
    }

    private function formatedtHits()
    {
        $firstHit = $this->resource->toArray();
        return Arr::get($firstHit, 'hits.hits');
    }
}
