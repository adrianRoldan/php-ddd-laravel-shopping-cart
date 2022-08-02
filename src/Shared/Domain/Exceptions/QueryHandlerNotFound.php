<?php

namespace Cart\Shared\Domain\Exceptions;


class QueryHandlerNotFound extends BaseDomainException
{

    public static function fromQueryClass(string $queryClass): self
    {
        return new self('Query handler not found for ' . $queryClass);
    }
}
