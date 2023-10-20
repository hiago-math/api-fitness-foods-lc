<?php

namespace Infrastructure\Repositories\Products;

use App\Infrastructure\Models\Product;
use Domain\Products\Interfaces\Repositories\ISynctRepository;
use Illuminate\Support\Collection;
use Infrastructure\Repositories\AbstractRepository;
use Shared\DTO\Product\CreateProductDTO;

class SynctRepository extends AbstractRepository implements ISynctRepository
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

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
}
