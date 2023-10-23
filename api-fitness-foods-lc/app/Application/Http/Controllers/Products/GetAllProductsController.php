<?php

namespace Application\Http\Controllers\Products;

use Application\Http\Controllers\Controller;
use Application\Http\Resource\PaginateResource;
use Application\Http\Validators\Utils\PaginateValidator;
use Domain\Products\Interfaces\Repositories\IProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Shared\DTO\Utils\PaginateDTO;

class GetAllProductsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="List all products",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page of result",
     *     ),
     *     @OA\Response(response="200", description="List of products"),
     * )
     */
    public function __invoke(
        Request            $request,
        PaginateDTO        $paginateDto,
        PaginateValidator $paginateValidator,
        IProductRepository $productRepository,
    ): JsonResponse
    {
        try {
            $this->validate($request, $paginateValidator::getRules(), $paginateValidator::getMessages());

            $paginateDto->register(...$request->all());
            $products = $productRepository->getAllProducts($paginateDto);

            if ($products->isEmpty()) {
                return $this->response_fail([], __('default.process_empty'));
            }

            return $this->response_ok((new PaginateResource($products))->toArray($request), __('default.process_ok'));
        } catch (ValidationException $e){
            send_log($e->getMessage(), $e->errors(), 'error', $e);
            return $this->response_fail($e->errors(), __('message.error'));
        } catch (\Exception $e) {
            send_log($e->getMessage(), [], 'error', $e);
            return $this->response_fail($e->getMessage(), __('message.internal_server_error'), 500);
        }
    }
}
