<?php

namespace Domain\Files\Commands;

use Domain\Files\Jobs\UnzipGzFileJob;
use Domain\Files\Interfaces\Services\IFileService;
use Domain\Products\Jobs\ProcessDataProductsJob;
use Illuminate\Console\Command;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Queue;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;

class DownloadFilesOpenFoodsCommand extends Command
{
    public function __construct(
        private IFileService $fileService
    )
    {
        parent::__construct();
    }

    protected $signature = 'download:files';

    public function handle(
        IOpenFoodApi $openFoodApi,
    )
    {
        $this->info('Iniciando downloads dos arquivos');
        try {
            $filenames = $openFoodApi->getFilesGz();
            $filenames = explode(PHP_EOL, $filenames);

            foreach ($filenames as $filename) {
                if (empty($filename)) continue;
                $this->info("Arquivo $filename");

                $binFile = $this->fileService->downloadFile($filename);
                $pathGz = $this->saveFileGz($binFile, $filename);

                Queue::push(new UnzipGzFileJob($pathGz, $filename));
            }
        } catch (\Exception $exception) {
            send_log($exception->getMessage(), ['CLASS' => __CLASS__], 'error', $exception);
        }
    }

    /**
     * @param string $binFile
     * @param string $name
     * @return string
     */
    private function saveFileGz(string $binFile, string $name): string
    {
        $path = 'gz/' . $name;
        return $this->fileService->saveFileStorage($binFile, $path);
    }

}
