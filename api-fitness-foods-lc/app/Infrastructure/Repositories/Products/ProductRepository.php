<?php

namespace Infrastructure\Repositories\Products;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Infrastructure\Models\Product;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Support\Collection;
use Infrastructure\Repositories\AbstractRepository;
use Shared\DTO\Product\CreateProductDTO;
use Shared\DTO\Product\UpdatedProductDTO;
use Shared\DTO\Utils\PaginateDTO;
use Shared\Enums\StatusProductEnum;

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
            ->whereNot('status', StatusProductEnum::TRASH)
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

    /**
     * @{inheritDoc}
     */
    public function updateProductByCode(UpdatedProductDTO $updatedProductDto): bool
    {
        return $this->getModel()
            ->where('code', $updatedProductDto->code)
            ->update(
                remove_null_array($updatedProductDto->toArray(except: ['code']))
            );
    }


    /**
     * @{inheritDoc}
     * @throws BindingResolutionException
     */
    public function deleteProductByCode(string $code): bool
    {
        $updatedProductDto = instantiate_class(UpdatedProductDTO::class);
        $updatedProductDto->register($code, StatusProductEnum::TRASH);

        return $this->updateProductByCode($updatedProductDto);
    }
}
