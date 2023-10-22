<?php

namespace Domain\Products\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Shared\DTO\Product\CreateProductDTO;
use Shared\DTO\Product\UpdatedProductDTO;
use Shared\DTO\Utils\PaginateDTO;

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

    /**
     * @param PaginateDTO $paginateDto
     * @return LengthAwarePaginator
     */
    public function getAllProducts(PaginateDTO $paginateDto): LengthAwarePaginator;

    /**
     * @param string $code
     * @return Collection
     */
    public function getProductByCode(string $code): Collection;

    /**
     * @param UpdatedProductDTO $updatedProductDto
     * @return bool
     */
    public function updateProductByCode(UpdatedProductDTO $updatedProductDto): bool;

    /**
     * @param string $code
     * @return bool
     */
    public function deleteProductByCode(string $code): bool;

}
