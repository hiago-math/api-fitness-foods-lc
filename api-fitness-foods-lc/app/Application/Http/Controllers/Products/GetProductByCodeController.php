<?php

namespace Application\Http\Controllers\Products;

use Application\Http\Controllers\Controller;
use Application\Http\Validators\Products\ProductByCodeValidator;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GetProductByCodeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/{code}",
     *     summary="List product by code",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Code of products",
     *     ),
     *     @OA\Response(response="200", description="Produto encontrado"),
     *     @OA\Response(
     *          response="404",
     *          description="Produto não encontrado",
     *      )
     * )
     */
    public function __invoke(
        string                    $code,
        Request                   $request,
        IProductRepository        $productRepository,
        ProductByCodeValidator $getProductByCodeValidator
    ): JsonResponse
    {
        try {
            $request->merge([
                'code' => $code
            ]);
            $this->validate($request, $getProductByCodeValidator::getRules(), $getProductByCodeValidator::getMessages());

            $product = $productRepository->getProductByCode($code);
            dd($product);

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
