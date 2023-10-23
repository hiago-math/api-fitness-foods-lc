<?php

namespace App\Infrastructure\Elasticsearch\Request;

use Illuminate\Support\Collection;
use Infrastructure\Elasticsearch\Request\StructureAbstract;

class SearchBuilder extends StructureAbstract
{

    /**
     * @param string $index
     * @param string|null $docType
     * @param array $payload
     */
    public function __construct(string $index, string $docType = null, array $payload = [])
    {
        parent::__construct($index, $docType, $payload);
    }

    public function handle(): Collection
    {
        return collect($this->client->search($this->toArray()));
    }
}
