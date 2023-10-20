<?php

namespace Domain\Files\Services;

use Domain\Files\Interfaces\Services\IFileService;
use Infrastructure\Apis\OpenFoods\Services\OpenFoodApi;

class FileService implements IFileService
{
    public function __construct(
        private OpenFoodApi $openFoodApi
    ) {}
    public function downloadFile(string $nameFile)
    {
        return $this->openFoodApi->downloadFile($nameFile);
    }

    public function saveFileStorage()
    {
        // TODO: Implement saveFileStorage() method.
    }

    public function cleanStoage()
    {
        // TODO: Implement cleanStoage() method.
    }
}
