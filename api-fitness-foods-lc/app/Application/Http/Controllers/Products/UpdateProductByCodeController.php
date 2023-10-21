<?php

namespace Application\Http\Controllers\Products;

use Application\Http\Controllers\Controller;
use Application\Http\Validators\Products\UpdateProductByCodeValidator;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Shared\DTO\Product\UpdatedProductDTO;

class UpdateProductByCodeController extends Controller
{
    public function __invoke(
        string                       $code,
        Request                      $request,
        UpdatedProductDTO            $updatedProductDto,
        IProductRepository           $productRepository,
        UpdateProductByCodeValidator $updateProductByCodeValidator
    )
    {
        try {
            $request->merge([
                'code' => $code
            ]);
            $this->validate($request, $updateProductByCodeValidator::getRules(), $updateProductByCodeValidator::getMessages());

            $updatedProductDto->register(...$request->all());

            $updated = $productRepository->updateProductByCode($updatedProductDto);

            if (!$updated) {
                return $this->response_fail([], __('default.process_empty'), 404);
            }

            return $this->response_ok([], __('default.process_ok'));
        } catch (ValidationException $e) {
            return $this->response_fail($e->errors(), __('message.error'));
        } catch (\Exception $e) {
            return $this->response_fail($e->getMessage(), __('message.error'), 500);
        }
    }
}
