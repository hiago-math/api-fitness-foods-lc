<?php

namespace Domain\Files\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Infrastructure\Apis\OpenFoods\Interfaces\IOpenFoodApi;

class DownloadFilesOpenFoodsCommand extends Command
{
    protected $signature = 'download:files';

    public function handle(IOpenFoodApi $openFoodApi)
    {
        $nameFiles = $openFoodApi->getFilesGz();

        $nameFiles = explode(PHP_EOL, $nameFiles);
        foreach ($nameFiles as $nameFile) {
            $binFile = $openFoodApi->downloadFile($nameFile);
            $path = 'sync_products/' . Str::beforeLast($nameFile, '.gz');
            Storage::disk('downloads')->put($path, $binFile);
            dd();
        }
    }
}
