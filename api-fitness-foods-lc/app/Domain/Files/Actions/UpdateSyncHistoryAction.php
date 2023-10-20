<?php

namespace App\Domain\Files\Actions;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Domain\Files\Interfaces\Services\IFileService;
use Infrastructure\Apis\OpenFoods\Services\OpenFoodApi;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\Enums\StatusSyncHistoryEnum;

class UpdateSyncHistoryAction
{
    public function __construct(
        private ISyncRepository $syncRepository,
    ) {}


    public function execute(CreateSyncHistoryDTO $createSyncHistoryDto)
    {
        $this->syncRepository->createSyncHistory($createSyncHistoryDto);
    }
}
