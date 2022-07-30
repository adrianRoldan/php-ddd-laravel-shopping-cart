<?php

namespace Cart\Shared\Domain\Exceptions;

use Cart\Shared\Domain\Contracts\DomainExceptionContract;

class CommandHandlerNotFound extends BaseDomainException
{

    public static function fromMessage(string $message): DomainExceptionContract
    {
        return new self($message);
    }
}
