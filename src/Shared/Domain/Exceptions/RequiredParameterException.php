<?php

namespace Cart\Shared\Domain\Exceptions;

class RequiredParameterException extends BaseDomainException
{
    /** @var int $code */
    protected $code = 422;

    public static function fromParameter(string $attribute): self
    {
        return new self("The parameter '" . $attribute . "' is required");
    }

}
