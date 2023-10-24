<?php

namespace Domain\Logs\Interfaces\Services;

use Illuminate\Support\Collection;
use Shared\DTO\Elasticsearch\CreateElasticsearchDTO;
use Shared\DTO\Elasticsearch\GetErrorElasticsearchDTO;

interface ILogService
{
    /**
     * @param GetErrorElasticsearchDTO $getErrorElasticsearchDto
     * @return Collection
     */
    public function getErrorLogs(GetErrorElasticsearchDTO $getErrorElasticsearchDto): Collection;

    /**
     * @param CreateElasticsearchDTO $createElasticsearchDto
     * @return Collection
     */
    public function createLog(CreateElasticsearchDTO $createElasticsearchDto): Collection;
}
