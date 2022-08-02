<?php

namespace Cart\Shared\Domain\Exceptions;


final class ValidationUuidException extends BaseDomainException
{
    public static function fromValue(string $value): self
    {
        return new self("The Unique ID ($value) don't has the correct format");
    }
}
