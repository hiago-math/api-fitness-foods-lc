<?php

namespace Domain\Products\Interfaces\Repositories;

use Illuminate\Support\Collection;
use Shared\DTO\Product\CreateProductDTO;

interface IProductRepository
{
    public function createProducts(CreateProductDTO $createProductDto): Collection;
}
