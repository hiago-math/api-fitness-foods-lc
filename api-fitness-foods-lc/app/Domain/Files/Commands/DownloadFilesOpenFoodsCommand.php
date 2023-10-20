<?php

namespace Domain\Files\Commands;

use Domain\Files\Interfaces\Services\IFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;

class DownloadFilesOpenFoodsCommand extends Command
{
    protected $signature = 'download:files';

    public function handle(
        IOpenFoodApi $openFoodApi,
        IFileService $fileService,

    )
    {
        $nameFiles = $openFoodApi->getFilesGz();

        $nameFiles = explode(PHP_EOL, $nameFiles);
        foreach ($nameFiles as $nameFile) {
            $binFile = $fileService->downloadFile($nameFile);
            $hash = $this->getHashFile($binFile);


        }
    }

    private function getHashFile(string $binFile)
    {
        $fileContent = file_get_contents($binFile);

        return hash('md5', $fileContent);
    }
}
