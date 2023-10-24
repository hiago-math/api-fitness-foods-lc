<?php

namespace Infrastructure\Apis\Elasticsearch\Services;

use Infrastructure\Apis\Elasticsearch\ElasticsearchServiceAbstract;
use Infrastructure\Apis\Elasticsearch\Interfaces\IElasticsearchApi;
use Illuminate\Support\Collection;
use Shared\DTO\Elasticsearch\CreateElasticsearchDTO;
use Shared\DTO\Elasticsearch\SearchElasticsearchDTO;

class ElasticsearchApi extends ElasticsearchServiceAbstract implements IElasticsearchApi
{
    public function create(CreateElasticsearchDTO $createElasticsearchDto): Collection
    {
        return collect($this->client->index($createElasticsearchDto->toArray()));
    }

    public function search(SearchElasticsearchDTO $searchElasticsearchDto): Collection
    {
        $response  = $this->client->search($searchElasticsearchDto->toArray());
        return $this->validateResponse($response);
    }
}
