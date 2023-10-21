<?php

namespace Application\Http\Controllers\Products;

use Application\Http\Controllers\Controller;
use Application\Http\Validators\Products\GetProductByCodeValidator;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GetProductByCodeController extends Controller
{
    public function __invoke(
        string                    $code,
        Request                   $request,
        IProductRepository        $productRepository,
        GetProductByCodeValidator $getProductByCodeValidator
    ): JsonResponse
    {
        try {
            $this->validate($request, $getProductByCodeValidator::getRules(), $getProductByCodeValidator::getMessages());

            $product = $productRepository->getProductByCode($code);

            if ($product->isEmpty()) {
                return $this->response_fail([], __('default.process_empty'), 404);
            }

            return $this->response_ok($product, __('default.process_ok'));
        } catch (ValidationException $e) {
            return $this->response_fail($e->errors(), __('message.error'));
        } catch (\Exception $e) {
            return $this->response_fail($e->getMessage(), __('message.error'), 500);
        }
    }
}
