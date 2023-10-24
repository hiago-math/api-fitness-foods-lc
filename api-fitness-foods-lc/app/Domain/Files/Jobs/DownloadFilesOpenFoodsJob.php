<?php

namespace App\Domain\Files\Jobs;

use Domain\Files\Actions\UnzipGzFileAction;
use Domain\Files\Interfaces\Services\IFileService;
use Domain\Files\Jobs\UnzipGzFileJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;

class DownloadFilesOpenFoodsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private IFileService $fileService;
    public function __construct(private string $filename)
    {
        $this->fileService =instantiate_class(IFileService::class);
    }

    public function handle(): void
    {
        try {
            $binFile = $this->fileService->downloadFile($this->filename);
            $pathGz = $this->saveFileGz($binFile, $this->filename);

            Queue::push(new UnzipGzFileJob($pathGz, $this->filename));
        } catch (\Exception $exception) {
            send_log($exception->getMessage(), ['filename' => $this->filename], 'error', $exception);
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
