<?php

namespace Domain\Files\Interfaces\Repositories;

use Illuminate\Support\Collection;
use Shared\DTO\Files\CreateSyncHistoryDTO;

interface ISyncRepository
{
    public function createSyncHistory(CreateSyncHistoryDTO $createSyncHistoryDto): Collection;
}
