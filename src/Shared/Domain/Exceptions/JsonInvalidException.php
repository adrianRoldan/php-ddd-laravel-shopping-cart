<?php

namespace Cart\Shared\Domain\Exceptions;


class JsonInvalidException extends BaseDomainException
{
    protected $code = 400;
    protected $message = "Invalid JSON";
}
