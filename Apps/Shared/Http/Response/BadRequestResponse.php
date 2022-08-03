<?php

namespace Apps\Shared\Http\Response;

class BadRequestResponse extends JsonResponse
{
    protected static int $code = HttpCode::HTTP_BAD_REQUEST;

    public static function code(): int
    {
        return HttpCode::HTTP_BAD_REQUEST;
    }
}
