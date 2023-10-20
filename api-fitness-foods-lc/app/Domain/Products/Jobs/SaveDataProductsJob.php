<?php

namespace App\Domain\Products\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Shared\DTO\Product\CreateProductDTO;

class SaveDataProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private array $contents
    )
    {}

    public function handle(
        CreateProductDTO $createProductDto
    )
    {
        foreach ($this->contents as $content) {
            $dto = $createProductDto->register(...$content);
            dd($dto->toArray());

        }
    }
}
