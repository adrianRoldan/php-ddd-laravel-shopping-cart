<?php

namespace Cart\Shared\Domain\Exceptions;


class JsonInvalidException extends BaseDomainException
{
    /** @var int $code */
    protected $code = 400;
    /** @var string $message */
    protected $message = "Invalid JSON";
}
