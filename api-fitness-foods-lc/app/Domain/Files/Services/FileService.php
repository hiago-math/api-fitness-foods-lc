<?php

namespace Domain\Files\Services;

use Domain\Files\Interfaces\Services\IFileService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use Infrastructure\Apis\OpenFoods\Services\OpenFoodApi;

class FileService implements IFileService
{
    public function __construct(
        private OpenFoodApi $openFoodApi
    ) {}

    /**
     * @throws GuzzleException
     */
    public function downloadFile(string $filename): string
    {
        return $this->openFoodApi->downloadFile($filename);
    }

    public function deleteFile(string $path): void
    {
        Storage::disk('downloads')->delete($path);
    }

    public function saveFileStorage(string $content, string $path, string $disk = 'downloads'): string
    {
        Storage::disk('downloads')->put($path, $content);

        return Storage::disk('downloads')->path($path);
    }
}
