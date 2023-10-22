<?php

namespace Domain\Products\Jobs;

use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Shared\DTO\Files\UpdateSyncHistoryDTO;
use Shared\DTO\Product\CreateProductDTO;
use Shared\Enums\StatusSyncHistoryEnum;

class SaveDataProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private array  $contents,
        private string $hash
    )
    {
    }

    public function handle(
        ISyncRepository    $syncRepository,
        CreateProductDTO   $createProductDto,
        IProductRepository $productRepository,
        UpdateSyncHistoryDTO $updateSyncHistoryDto
    )
    {
        try {
            $updateSyncHistoryDto->register($this->hash);
            $syncRepository->updateSyncHistory($updateSyncHistoryDto);

            foreach ($this->contents as $content) {
                $fields = $productRepository->getFillable();
                $content = collect($content)
                    ->only($fields)
                    ->toArray();

                $dto = $createProductDto->register(...$content);
                $productRepository->createProducts($dto);

                $updateSyncHistoryDto->register($this->hash, StatusSyncHistoryEnum::FINISHED);
                $syncRepository->updateSyncHistory($updateSyncHistoryDto);
            }
        } catch (\Exception $exception) {
            send_log($exception->getMessage(), $this->contents, 'error', $exception);

            $updateSyncHistoryDto->register($this->hash, StatusSyncHistoryEnum::ERROR);
            $syncRepository->updateSyncHistory($updateSyncHistoryDto);
        }
    }
}
