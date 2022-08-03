<?php

namespace Apps\Shared\Http\Response;

use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Throwable;

interface JsonResponseContract
{
    public static function fromMessage(string $message): LaravelJsonResponse;
    public static function fromResource(ResourceContract $resource): LaravelJsonResponse;
    public static function fromException(Throwable $exception): LaravelJsonResponse;
}
