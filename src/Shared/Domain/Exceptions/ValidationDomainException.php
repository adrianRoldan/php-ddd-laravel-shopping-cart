<?php

namespace Cart\Shared\Domain\Exceptions;


class ValidationDomainException extends BaseDomainException
{
    protected $code = 422;
}
