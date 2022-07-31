<?php

namespace Cart\Shared\Domain\Exceptions;

use Cart\Shared\Domain\Contracts\DomainExceptionContract;

class InvalidEnumException extends BaseDomainException
{

    public static function fromMessage(string $message): DomainExceptionContract
    {
        // TODO: Implement fromMessage() method.
    }
}
