<?php

namespace Infrastructure\Repositories\Products;

use Infrastructure\Models\Product;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Domain\Products\Interfaces\Repositories\ISynctRepository;
use Illuminate\Support\Collection;
use Infrastructure\Repositories\AbstractRepository;
use Shared\DTO\Product\CreateProductDTO;

class ProductRepository extends AbstractRepository implements IProductRepository
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

    /**
     * @{inheritDoc}
     */
    public function createProducts(CreateProductDTO $createProductDto): Collection
    {
       $product = $this->getModel()
           ->firstOrCreate(
               [
                   'code' => $createProductDto->code
               ],
               $createProductDto->toArray()
           );

       return $this->toCollect($product->toArray());
    }

    /**
     * @{inheritDoc}
     */
    public function getFillable(): array
    {
       return $this->getModel()->getFillable();
    }
}