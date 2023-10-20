<?php

namespace App\Domain\Products\Jobs;

use Domain\Files\Actions\UnzipGzFileAction;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnzipGzFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $binFile,
        private string $filename,
    )
    {}

    public function handle(UnzipGzFileAction $unzipGzFileAction)
    {
        try {
            $unzipGzFileAction->execute($this->filename, $this->binFile);
        } catch (\Exception $exception) {
            send_log($exception->getMessage(), ['filename' => $this->filename], 'Error', $exception);
        }
}
