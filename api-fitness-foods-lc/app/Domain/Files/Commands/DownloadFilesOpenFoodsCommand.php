<?php

namespace Domain\Files\Commands;

use Domain\Files\Actions\UnzipFileAction;
use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Domain\Files\Interfaces\Services\IFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\Enums\StatusSyncHistoryEnum;

class DownloadFilesOpenFoodsCommand extends Command
{
    protected $signature = 'download:files';

    public function handle(
        IOpenFoodApi $openFoodApi,
        IFileService $fileService,
        ISyncRepository $syncRepository,
        UnzipFileAction $unzipFileAction,
        CreateSyncHistoryDTO $createSyncHistoryDto,
    )
    {
        $nameFiles = $openFoodApi->getFilesGz();

        $nameFiles = explode(PHP_EOL, $nameFiles);
        foreach ($nameFiles as $nameFile) {
            $binFile = $fileService->downloadFile($nameFile);

            $unzipFileAction->execute($nameFile, $binFile);

            dd();

            $createSyncHistoryDto->register($hash, $nameFile, StatusSyncHistoryEnum::STARTED);
            $syncRepository->createSyncHistory($createSyncHistoryDto);


        }
    }

    private function getHashFile(string $binFile)
    {
        $fileContent = file_get_contents($binFile);

        return hash('md5', $fileContent);
    }
}
