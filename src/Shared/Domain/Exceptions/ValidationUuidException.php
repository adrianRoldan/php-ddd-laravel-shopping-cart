<?php

namespace Cart\Shared\Domain\Exceptions;


final class ValidationUuidException extends BaseDomainException
{
    /** @var int $code */
    protected $code = 422;

    public static function fromValue(string $value): self
    {
        return new self("The Unique Universal ID ($value) don't has the correct format");
    }
}
