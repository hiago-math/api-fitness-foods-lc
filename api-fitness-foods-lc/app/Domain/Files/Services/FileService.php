<?php

namespace Domain\Files\Services;

use Domain\Files\Interfaces\Services\IFileService;
use Illuminate\Support\Facades\Storage;
use Infrastructure\Apis\OpenFoods\Services\OpenFoodApi;

class FileService implements IFileService
{
    public function __construct(
        private OpenFoodApi $openFoodApi
    ) {}
    public function downloadFile(string $filename)
    {
        return $this->openFoodApi->downloadFile($filename);
    }

    public function saveFileStorage()
    {
        // TODO: Implement saveFileStorage() method.
    }

    public function cleanStoage(string $path = '/gz')
    {
        Storage::disk('download')->deleteDirectory($path);
    }
}
