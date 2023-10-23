<?php

namespace Infrastructure\Elasticsearch\Request;

use Illuminate\Support\Collection;

class CreateBuilder extends StructureAbstract
{
    public function __construct(string $index, string $docType = null, array $payload = [])
    {
        parent::__construct($index, $docType, $payload);
    }

    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        return collect($this->client->index($this->toArray()));
    }
}
