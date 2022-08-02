<?php

namespace Cart\Shared\Domain\Exceptions;

use Cart\Shared\Domain\Contracts\DomainExceptionContract;
use DomainException;

abstract class BaseDomainException extends DomainException implements DomainExceptionContract
{
    public static function fromMessage(string $message): DomainExceptionContract
    {
        return new static($message);
    }
}
