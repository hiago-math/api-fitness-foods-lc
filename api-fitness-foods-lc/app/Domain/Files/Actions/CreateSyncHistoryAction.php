<?php

namespace Domain\Files\Actions;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Domain\Files\Interfaces\Services\IFileService;
use Infrastructure\Apis\OpenFoods\Services\OpenFoodApi;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\Enums\StatusSyncHistoryEnum;

class CreateSyncHistoryAction
{
    public function __construct(
        private ISyncRepository $syncRepository,
    ) {}


    public function execute(CreateSyncHistoryDTO $createSyncHistoryDto)
    {
        $this->syncRepository->createSyncHistory($createSyncHistoryDto);
    }
}
