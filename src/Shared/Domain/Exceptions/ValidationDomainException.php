<?php

namespace Cart\Shared\Domain\Exceptions;


class ValidationDomainException extends BaseDomainException
{
    /** @var int $code */
    protected $code = 422;
}
