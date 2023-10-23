<?php

namespace Infrastructure\Elasticsearch;

use App\Infrastructure\Elasticsearch\Request\SearchBuilder;
use Illuminate\Support\Collection;
use Infrastructure\Elasticsearch\Request\CreateBuilder;
use Shared\DTO\GetErrorElasticsearchDTO;

class Rest
{
    /**
     * @param string $index
     * @param string $type
     * @param array $payload
     * @return Collection
     */
    public static function create(string $index, string $type, array $payload): Collection
    {
        return (new CreateBuilder($index, $type, $payload))->handle();
    }

    /**
     * @param string $index
     * @param GetErrorElasticsearchDTO $errorElasticsearchDto
     * @return Collection
     */
    public static function search(GetErrorElasticsearchDTO $errorElasticsearchDto): Collection
    {
        $fields = remove_null_array($errorElasticsearchDto->toArray(except: ['index']));

        if (empty($fields)) return collect([]);

        $payload = [
                'query' => [
                    'match' => $fields
            ],
        ];
        return (new SearchBuilder($errorElasticsearchDto->index, payload: $payload))->handle();
    }
}
