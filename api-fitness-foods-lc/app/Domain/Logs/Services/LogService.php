<?php

namespace Domain\Logs\Services;

use Infrastructure\Apis\Elasticsearch\Interfaces\IElasticsearchApi;
use Domain\Logs\Interfaces\Services\ILogService;
use Illuminate\Support\Collection;
use Shared\DTO\Elasticsearch\CreateElasticsearchDTO;
use Shared\DTO\Elasticsearch\GetErrorElasticsearchDTO;
use Shared\DTO\Elasticsearch\SearchElasticsearchDTO;
use Shared\Enums\DocTypesElasticsearchEnum;

class LogService implements ILogService
{
    public function __construct(
        private IElasticsearchApi      $elasticsearchApi,
        private SearchElasticsearchDTO $searchElasticsearchDto
    )
    { }

    /**
     * {inheritDoc}
     */
    public function getErrorLogs(GetErrorElasticsearchDTO $getErrorElasticsearchDto): Collection
    {
        $payload = remove_null_array($getErrorElasticsearchDto->toArray(except: ['index']));

        $this->searchElasticsearchDto->register(
            $getErrorElasticsearchDto->index,
            DocTypesElasticsearchEnum::ERROR,
            $payload
        );

        return $this->elasticsearchApi->search($this->searchElasticsearchDto);
    }

    public function createLog(CreateElasticsearchDTO $createElasticsearchDto): Collection
    {
       return $this->elasticsearchApi->create($createElasticsearchDto);
    }
}
