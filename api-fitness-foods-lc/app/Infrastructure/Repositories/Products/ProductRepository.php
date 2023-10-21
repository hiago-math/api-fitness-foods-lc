<?php

namespace Infrastructure\Repositories\Products;

use Illuminate\Pagination\LengthAwarePaginator;
use Infrastructure\Models\Product;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Support\Collection;
use Infrastructure\Repositories\AbstractRepository;
use Shared\DTO\Product\CreateProductDTO;
use Shared\DTO\Utils\PaginateDTO;

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

    /**
     * @{inheritDoc}
     */
    public function getAllProducts(PaginateDTO $paginateDto): LengthAwarePaginator
    {
        return $this->getModel()
            ->paginate($paginateDto->per_page, ['*'], 'page',$paginateDto->page);
    }

    /**
     * @{inheritDoc}
     */
    public function getProductByCode(string $code): Collection
    {
        $product = $this->getModel()
            ->where('code', $code)
            ->first()
            ?->toArray();

        return $this->toCollect($product);
    }
}
