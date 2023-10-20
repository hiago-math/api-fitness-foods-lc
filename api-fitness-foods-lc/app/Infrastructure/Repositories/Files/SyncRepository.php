<?php

namespace Infrastructure\Repositories\Files;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Illuminate\Support\Collection;
use Infrastructure\Models\SyncHistory;
use Infrastructure\Repositories\AbstractRepository;
use Shared\DTO\Files\CreateSyncHistoryDTO;

class SyncRepository extends AbstractRepository implements ISyncRepository
{
    public function __construct()
    {
        parent::__construct(SyncHistory::class);
    }

    public function createSyncHistory(CreateSyncHistoryDTO $createSyncHistoryDto): Collection
    {
       $history = $this->getModel()
           ->firstOrCreate(
               $createSyncHistoryDto->toArray()
           );

       return $this->toCollect($history->toArray());
    }
}
