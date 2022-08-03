<?php

namespace Apps\Shared\Http\Response;

use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Throwable;

class JsonResponse implements JsonResponseContract
{
    protected static int $code = HttpCode::HTTP_OK;

    public static function fromMessage(string $message): LaravelJsonResponse
    {
        return static::buildResponse($message, self::$code);
    }

    public static function fromException(Throwable $exception): LaravelJsonResponse
    {
        $code = ($exception->getCode() && $exception->getCode() <= HttpCode::HTTP_MAX_CODE) ? $exception->getCode() : HttpCode::HTTP_INTERNAL_SERVER_ERROR;
        return static::buildResponse($exception->getMessage(), $code);
    }


    public static function fromResource(ResourceContract $resource): LaravelJsonResponse
    {
        return static::buildResponse(null, HttpCode::HTTP_OK, $resource->toArray());
    }


    private static function buildResponse(?string $message, int $code, array $data = []): LaravelJsonResponse
    {
        $response = [];

        if($message) {
            $response['message'] = $message;
        }
        if(!empty($data)){
            if($message) {
                return response()->json(array_merge($response, ["data" => $data]), $code);
            }
            return response()->json($data, $code);
        }

        return response()->json($response, $code);
    }
}
