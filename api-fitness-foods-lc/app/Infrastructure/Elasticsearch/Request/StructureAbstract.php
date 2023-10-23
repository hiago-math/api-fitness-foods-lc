<?php

namespace Infrastructure\Elasticsearch\Request;

use Elasticsearch\ClientBuilder;

/**
 * Class StructureAbstract
 * Suporta uma estrutura básica para todas as requisições do elasticsearch
 */
abstract class StructureAbstract
{
    protected $client;

    protected $structure;

    public function __construct(string $index, string $docType = null, array $payload = [])
    {
        $this->client = ClientBuilder::create()->setHosts([config('custom.ELASTICSEARCH_URL')])->setRetries(0)->build();

        $this->structure = [
            'index' => $index,
            'type'  => $docType,
            'body'  => $payload
        ];

    }

    public function toArray(): array
    {
        return $this->structure;
    }

    public function toJson(): string
    {
        return json_encode($this->structure);
    }
}
