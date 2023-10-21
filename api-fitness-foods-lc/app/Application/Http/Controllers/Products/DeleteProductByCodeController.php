<?php

namespace App\Application\Http\Controllers\Products;

use Application\Http\Controllers\Controller;
use Application\Http\Validators\Products\ProductByCodeValidator;
use Application\Http\Validators\Products\UpdateProductByCodeValidator;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Shared\DTO\Product\UpdatedProductDTO;

class DeleteProductByCodeController extends Controller
{
    public function __invoke(
        string                 $code,
        Request                $request,
        IProductRepository     $productRepository,
        ProductByCodeValidator $productByCodeValidator,
    )
    {
        try {
            $request->merge([
                'code' => $code
            ]);
            $this->validate($request, $productByCodeValidator::getRules(), $productByCodeValidator::getMessages());

            $deleted = $productRepository->deleteProductByCode($code);

            if (!$deleted) {
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
