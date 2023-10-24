<?php

namespace Application\Http\Controllers\Logs;

use Domain\Logs\Interfaces\Services\ILogService;
use Application\Http\Controllers\Controller;
use Application\Http\Resource\Errors\GetErrorsElasticsearchResource;
use Application\Http\Validators\Logs\LogsElasticsearchValidator;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Shared\DTO\Elasticsearch\GetErrorElasticsearchDTO;

class GetLogsElasticsearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/logs",
     *     summary="List logs",
     *     tags={"Logs"},
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
     *     @OA\Response(response="200", description="List of logs elastichsearch"),
     * )
     */
    public function __invoke(
        Request                    $request,
        ILogService                $logService,
        GetErrorElasticsearchDTO   $errorElasticsearchDto,
        LogsElasticsearchValidator $logsElasticsearchValidator,
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

            $data = $logService->getErrorLogs($errorElasticsearchDto);

            if ($data->isEmpty()) return $this->response_fail(["use os campos 'message', 'message_exception' ou 'code' para refinar a busca!"], __('message.return_empty'));

            return $this->response_ok((new GetErrorsElasticsearchResource($data))->toArray($request), __('message.return_ok'));
        } catch (ValidationException $e) {
            send_log($e->getMessage(), $e->errors(), 'error', $e);
            return $this->response_fail($e->errors(), __('message.error'));
        } catch (Missing404Exception $e) {
            $response = json_decode($e->getMessage(), true);

            send_log($e->getMessage(), $response, 'error', $e);
            return $this->response_fail($response, __('message.error_elastic'), Arr::get($response, 'status'));
        } catch (\Exception $e) {
            send_log($e->getMessage(), $request->all(), 'error', $e);
            return $this->response_fail($e->getMessage(), __('message.internal_server_error'), 500);
        }
    }
}
