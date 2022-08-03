<?php

namespace Cart\Core\Product\Domain\Exceptions;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Domain\Exceptions\BaseDomainException;

class ProductNotFoundException extends BaseDomainException
{
    protected $code = 404;

    public static function fromProductId(ProductId $productId): self
    {
        return new self("The product with Id " .$productId->getValue(). " doesn't exists");
    }
}
