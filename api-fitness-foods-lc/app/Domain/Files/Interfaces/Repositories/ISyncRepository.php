<?php

namespace Domain\Files\Interfaces\Repositories;

use Illuminate\Support\Collection;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\DTO\Files\UpdateSyncHistoryDTO;

interface ISyncRepository
{
    public function createSyncHistory(CreateSyncHistoryDTO $createSyncHistoryDto): Collection;
    public function updateSyncHistory(UpdateSyncHistoryDTO $updateSyncHistoryDto): bool;
}
