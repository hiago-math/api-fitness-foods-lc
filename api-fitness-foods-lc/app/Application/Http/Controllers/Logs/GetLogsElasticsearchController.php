<?php

namespace Application\Http\Controllers\Logs;

use Application\Http\Resource\Errors\GetErrorsElasticsearchResource;
use Application\Http\Controllers\Controller;
use Application\Http\Validators\Logs\LogsElasticsearchValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Infrastructure\Elasticsearch\Rest;
use Shared\DTO\GetErrorElasticsearchDTO;

class GetLogsElasticsearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/logs",
     *     summary="List all products",
     *     @OA\Parameter(
     *          name="index",
     *          in="query",
     *          description="message of logs",
     *          required=true
     *      ),
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         description="message of logs",
     *     ),
     *     @OA\Parameter(
     *          name="message_exception",
     *          in="query",
     *          description="message_exception of logs",
     *      ),
     *     @OA\Parameter(
     *          name="message_exception",
     *          in="query",
     *          description="message_exception of logs",
     *       ),
     *     @OA\Response(response="200", description="List of errors elastichsearch"),
     * )
     */
    public function __invoke(
        Request                  $request,
        GetErrorElasticsearchDTO $errorElasticsearchDto,
        LogsElasticsearchValidator $logsElasticsearchValidator
    ): JsonResponse
    {
        try {
            $this->validate($request, $logsElasticsearchValidator::getRules(), $logsElasticsearchValidator::getMessages());

            $errorElasticsearchDto->register(
                $request->get('index'),
                $request->get('message'),
                $request->get('message_exception'),
                $request->get('code'),
            );

            $data = Rest::search($errorElasticsearchDto);

            if ($data->isEmpty()) return $this->response_fail(["use os campos 'message', 'message_exception' ou 'code' para refinar a busca!"], __('message.return_empty'));

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
