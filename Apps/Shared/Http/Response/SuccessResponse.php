<?php

namespace Apps\Shared\Http\Response;

class SuccessResponse extends JsonResponse
{
    protected static int $code = HttpCode::HTTP_OK;
}
