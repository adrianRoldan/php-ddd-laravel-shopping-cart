<?php

namespace Apps\Shared\Http\Response;

interface HttpCode
{
    public const HTTP_OK = 200;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_UNAVAILABLE = 503;


    public const HTTP_MAX_CODE = 599;

}
