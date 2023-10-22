<?php

namespace Domain\Files\Jobs;

use Domain\Files\Actions\UnzipGzFileAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnzipGzFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $pathGz,
        private string $filename,
    )
    {}

    public function handle(UnzipGzFileAction $unzipGzFileAction): void
    {
        try {
            $unzipGzFileAction->execute($this->filename, $this->pathGz);
        } catch (\Exception $exception) {
            send_log($exception->getMessage(), ['filename' => $this->filename], 'Error', $exception);
        }
    }
}
