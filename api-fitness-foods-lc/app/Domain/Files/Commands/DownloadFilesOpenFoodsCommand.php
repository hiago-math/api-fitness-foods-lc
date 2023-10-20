<?php

namespace Domain\Files\Commands;

use Domain\Files\Jobs\UnzipGzFileJob;
use Domain\Files\Interfaces\Services\IFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;

class DownloadFilesOpenFoodsCommand extends Command
{
    protected $signature = 'download:files';

    public function handle(
        IOpenFoodApi $openFoodApi,
        IFileService $fileService,
    )
    {
        try {
            $filenames = $openFoodApi->getFilesGz();
            $filenames = explode(PHP_EOL, $filenames);

            foreach ($filenames as $filename) {
                if (empty($filename)) continue;

                $binFile = $fileService->downloadFile($filename);
                Queue::pushOn('default', new UnzipGzFileJob($binFile, $filename));
            }
        } catch (\Exception $exception) {
            send_log($exception->getMessage());
        }
    }

}
