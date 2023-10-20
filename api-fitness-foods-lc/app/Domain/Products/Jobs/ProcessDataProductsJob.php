<?php
            $createSyncHistoryDto->register($hash, $filename, StatusSyncHistoryEnum::STARTED);
            $syncRepository->createSyncHistory($createSyncHistoryDto);

namespace Domain\Products\Jobs;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\Enums\StatusSyncHistoryEnum;

class ProcessDataProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $filename
    )
    {}

    public function handle(
        ISyncRepository $syncRepository,
        CreateSyncHistoryDTO $createSyncHistoryDto
    )
    {
        $createSyncHistoryDto->register($hash, $this->filename, StatusSyncHistoryEnum::STARTED);
        $syncRepository->createSyncHistory($createSyncHistoryDto);
    }


    private function getHashFile(string $binFile)
    {
        $fileContent = file_get_contents($binFile);

        return hash('md5', $fileContent);
    }
}
