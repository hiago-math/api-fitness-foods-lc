<?php

namespace Domain\Files\Actions;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Infrastructure\Apis\OpenFoods\Services\OpenFoodApi;
use Shared\DTO\Files\CreateSyncHistoryDTO;

class DownloadFileAction
{
    public function __construct(
        private OpenFoodApi $openFoodApi,
        private CreateSyncHistoryDTO $createSyncHistoryDto,
        private ISyncRepository $syncRepository
    ) {}


    public function execute(string $nameFile)
    {
        $binFile = $this->openFoodApi->downloadFile($nameFile);
        $hash = $this->getHashFile($binFile);

        $this->createSyncHistoryDto->register($hash, $nameFile);
        $this->syncRepository->createSyncHistory($this->createSyncHistoryDto);
    }

    private function getHashFile(string $binFile)
    {
        $fileContent = file_get_contents($binFile);

        return hash('md5', $fileContent);
    }
}
