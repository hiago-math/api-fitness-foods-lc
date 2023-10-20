<?php

namespace Domain\Products\Interfaces\Repositories;

use Illuminate\Support\Collection;
use Shared\DTO\Product\CreateProductDTO;

interface IProductRepository
{
    /**
     * @param CreateProductDTO $createProductDto
     * @return Collection
     */
    public function createProducts(CreateProductDTO $createProductDto): Collection;

    /**
     * @return array
     */
    public function getFillable(): array;
}
