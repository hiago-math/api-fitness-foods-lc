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
    public function downloadFile(string $filename): string
    {
        return $this->openFoodApi->downloadFile($filename);
    }

    public function cleanStoage(string $path = '/gz'): void
    {
        Storage::disk('download')->deleteDirectory($path);
    }

    public function saveFileStorage(string $content, string $path, string $disk = 'downloads'): string
    {
        Storage::disk('downloads')->put($path, $content);

        return Storage::disk('downloads')->path($path);
    }
}
