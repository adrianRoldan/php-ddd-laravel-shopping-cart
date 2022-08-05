<?php

namespace Cart\Core\Cart\Domain\Exceptions;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Domain\Exceptions\BaseDomainException;

class ProductInCartNotFound extends BaseDomainException
{
    /** @var int $code */
    protected $code = 404;

    public static function fromProductAndCart(ProductId $productId, CartId $cartId): self
    {
        return new self("The product ".$productId->getValue()." doesn't exist in the cart ".$cartId->getValue());
    }
}
