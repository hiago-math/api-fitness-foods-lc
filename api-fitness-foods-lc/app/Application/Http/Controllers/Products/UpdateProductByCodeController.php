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
    /**
     * @OA\Put(
     *     path="/api/products/{code}",
     *     tags={"Products"},
     *     summary="Atualizar informações de um produto por código",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         description="Código do produto a ser atualizado",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="url",
     *                 type="string",
     *                 example="http://world-en.openfoodfacts.org/product/0000000000017/vitoria-crackers"
     *             ),
     *             @OA\Property(
     *                 property="product_name",
     *                 type="string",
     *                 example="Vitória crackers"
     *             ),
     *             @OA\Property(
     *                 property="quantity",
     *                 type="string",
     *                 example="10"
     *             ),
     *             @OA\Property(
     *                 property="brands",
     *                 type="string",
     *                 example="Vigor"
     *             ),
     *             @OA\Property(
     *                 property="categories",
     *                 type="string",
     *                 example="Queijp"
     *             ),
     *             @OA\Property(
     *                 property="labels",
     *                 type="string",
     *                 example="Requeijapo cremoso"
     *             ),
     *             @OA\Property(
     *                 property="cities",
     *                 type="string",
     *                 example="SP"
     *             ),
     *             @OA\Property(
     *                 property="purchase_places",
     *                 type="string",
     *                 example="Mercados"
     *             ),
     *             @OA\Property(
     *                 property="stores",
     *                 type="string",
     *                 example="Pao de acucar"
     *             ),
     *             @OA\Property(
     *                 property="ingredients_text",
     *                 type="string",
     *                 example=""
     *             ),
     *             @OA\Property(
     *                 property="traces",
     *                 type="string",
     *                 example=""
     *             ),
     *             @OA\Property(
     *                 property="serving_size",
     *                 type="string",
     *                 example="100g"
     *             ),
     *             @OA\Property(
     *                 property="serving_quantity",
     *                 type="number",
     *                 example=0
     *             ),
     *             @OA\Property(
     *                 property="nutriscore_score",
     *                 type="number",
     *                 example=0
     *             ),
     *             @OA\Property(
     *                 property="nutriscore_grade",
     *                 type="string",
     *                 example="20"
     *             ),
     *             @OA\Property(
     *                 property="main_category",
     *                 type="string",
     *                 example="Laticinios"
     *             ),
     *             @OA\Property(
     *                 property="image_url",
     *                 type="string",
     *                 example="https://static.openfoodfacts.org/images/products/000/000/000/0017/front_fr.4.400.jpg"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Produto atualizado com sucesso",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Produto não encontrado",
     *     )
     * )
     */
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
        } catch (ValidationException $e){
            send_log($e->getMessage(), $e->errors(), 'error', $e);
            return $this->response_fail($e->errors(), __('message.error'));
        } catch (\Exception $e){
            send_log($e->getMessage(), $request->all(), 'error', $e);
            return $this->response_fail($e->getMessage(), __('message.internal_server_error'), 500);
        }
    }
}
