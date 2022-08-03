<?php

namespace Apps\Shared\Http\Response;

class UnavailableResponse extends JsonResponse
{
    protected static int $code = HttpCode::HTTP_UNAVAILABLE;
    public static function code(): int
    {
        return HttpCode::HTTP_UNAVAILABLE;
    }
}
