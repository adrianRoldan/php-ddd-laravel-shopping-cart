<?php

namespace Cart\Core\Cart\Domain\Exceptions;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Shared\Domain\Exceptions\BaseDomainException;

class MaxQuantityExceededPerProductException extends BaseDomainException
{
    /** @var int $code */
    protected $code = 422;

    public static function fromQuantity(int $quantity): self
    {
        return new self($quantity. " exceeds the maximum quantity per product allowed (". CartSettings::MAX_PER_PRODUCT .")");
    }
}
