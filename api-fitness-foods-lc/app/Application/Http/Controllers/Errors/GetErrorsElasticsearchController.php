<?php

namespace Application\Http\Controllers\Errors;

use Application\Http\Resource\Errors\GetErrorsElasticsearchResource;
use Application\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Infrastructure\Elasticsearch\Rest;
use Shared\DTO\GetErrorElasticsearchDTO;

class GetErrorsElasticsearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/errors",
     *     summary="List all products",
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         description="message of error",
     *     ),
     *     @OA\Parameter(
     *          name="message_exception",
     *          in="query",
     *          description="message_exception of error",
     *      ),
     *     @OA\Parameter(
     *          name="message_exception",
     *          in="query",
     *          description="message_exception of error",
     *       ),
     *     @OA\Response(response="200", description="List of errors elastichsearch"),
     * )
     */
    public function __invoke(
        Request                  $request,
        GetErrorElasticsearchDTO $errorElasticsearchDto
    ): JsonResponse
    {
        try {
            $errorElasticsearchDto->register(
                $request->get('message'),
                $request->get('message_exception'),
                $request->get('code'),
            );

            $data = Rest::search('errors', $errorElasticsearchDto);

            if ($data->isEmpty()) return $this->response_fail([], __('message.return_empty'));

            return $this->response_ok((new GetErrorsElasticsearchResource($data))->toArray($request), __('message.return_ok'));
        } catch (ValidationException $e) {
            send_log($e->getMessage(), $e->errors(), 'error', $e);
            return $this->response_fail($e->errors(), __('message.error'));
        } catch (\Exception $e) {
            send_log($e->getMessage(), $request->all(), 'error', $e);
            return $this->response_fail($e->getMessage(), __('message.internal_server_error'), 500);
        }
    }
}
