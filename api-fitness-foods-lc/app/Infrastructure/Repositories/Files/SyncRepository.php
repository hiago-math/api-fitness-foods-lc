<?php

namespace Infrastructure\Repositories\Files;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Illuminate\Support\Collection;
use Infrastructure\Models\SyncHistory;
use Infrastructure\Repositories\AbstractRepository;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\DTO\Files\UpdateSyncHistoryDTO;

class SyncRepository extends AbstractRepository implements ISyncRepository
{
    public function __construct()
    {
        parent::__construct(SyncHistory::class);
    }

    /**
     * @{inheritDoc}
     */
    public function createSyncHistory(CreateSyncHistoryDTO $createSyncHistoryDto): Collection
    {
        $history = $this->getModel()
            ->firstOrCreate(
                $createSyncHistoryDto->toArray()
            );

        return $this->toCollect($history->toArray());
    }

    /**
     * @{inheritDoc}
     */
    public function updateSyncHistory(UpdateSyncHistoryDTO $updateSyncHistoryDto): bool
    {
        return $this->getModel()
            ->where('hash', $updateSyncHistoryDto->hash)
            ->update(
                $updateSyncHistoryDto->toArray()
            );

    }
}
