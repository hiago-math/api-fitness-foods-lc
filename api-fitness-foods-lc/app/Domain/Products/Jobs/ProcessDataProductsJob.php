<?php

namespace Domain\Products\Jobs;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Domain\Files\Interfaces\Services\IFileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shared\DTO\Files\CreateSyncHistoryDTO;

class ProcessDataProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(
        IFileService $fileService
    )
    {
        try {
            $filenames = Storage::disk('downloads')->files('/js');

            foreach ($filenames as $filename) {
                $content = Storage::disk('downloads')->get($filename);

                $hash = get_hash_file($content);
                $this->createSyncHistory($hash, Str::after($filename, 'js/'));

                $content = $this->getFirstHundred($content);

                Queue::pushOn('default', new SaveDataProductsJob($content, $hash));
            }

            $fileService->cleanStoage('/js');
        } catch (\Exception $exception) {
            send_log($exception->getMessage());
        }

    }

    /**
     * @param string $content
     * @return array
     */
    private function getFirstHundred(string $content): array
    {
        $arrayContent = [];
        $firstHundred = explode(PHP_EOL, $content);

        foreach ($firstHundred as $item) {
            $arrayContent[] = json_decode($item, true);

            if (count($arrayContent) === 100) break;
        }
        return $arrayContent;
    }

    /**
     * @param string $hash
     * @param string $filename
     * @return void
     * @throws BindingResolutionException
     */
    private function createSyncHistory(string $hash, string $filename): void
    {
        $createSyncHistoryDto = instantiate_class(CreateSyncHistoryDTO::class);
        $createSyncHistoryDto->register($hash, $filename);

        $syncRepository = instantiate_class(ISyncRepository::class);
        $syncRepository->createSyncHistory($createSyncHistoryDto);
    }
}
