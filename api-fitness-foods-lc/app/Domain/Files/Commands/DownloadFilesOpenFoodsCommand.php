<?php

namespace Domain\Files\Commands;

use App\Domain\Files\Jobs\DownloadFilesOpenFoodsJob;
use Domain\Files\Jobs\UnzipGzFileJob;
use Domain\Files\Interfaces\Services\IFileService;
use Domain\Products\Jobs\ProcessDataProductsJob;
use Illuminate\Console\Command;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Queue;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;

class DownloadFilesOpenFoodsCommand extends Command
{
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

                Queue::push(new DownloadFilesOpenFoodsJob($filename));
            }
        } catch (\Exception $exception) {
            send_log($exception->getMessage(), ['CLASS' => __CLASS__], 'error', $exception);
        }
    }
}
