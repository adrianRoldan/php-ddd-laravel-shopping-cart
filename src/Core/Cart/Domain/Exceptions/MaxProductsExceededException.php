<?php

namespace Cart\Core\Cart\Domain\Exceptions;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Shared\Domain\Exceptions\BaseDomainException;

class MaxProductsExceededException extends BaseDomainException
{

    public static function create(): self
    {
        return new self("No more products can be added to the cart. Maximum ". CartSettings::MAX_DIFFERENT_PRODUCTS);
    }
}
