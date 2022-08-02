<?php

namespace Cart\Core\Cart\Domain\Exceptions;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Exceptions\BaseDomainException;

class MaxQuantityExceededPerProductException extends BaseDomainException
{
    public static function fromQuantity(ProductQuantity $quantity): self
    {
        return new self($quantity->getValue(). "exceeds the maximum quantity per product allowed (". CartSettings::MAX_PER_PRODUCT .")");
    }
}
