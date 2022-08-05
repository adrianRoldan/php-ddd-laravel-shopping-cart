<?php

namespace Cart\Core\Cart\Domain\Exceptions;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Exceptions\BaseDomainException;

class CartNotFoundException extends BaseDomainException
{
    /** @var int $code */
    protected $code = 404;

    public static function fromCartId(CartId $cartId): self
    {
        return new self("The cart with Id " .$cartId->getValue(). " doesn't exists");
    }

    public static function fromUserId(UserId $userId): self
    {
        return new self("The user with Id " .$userId->getValue(). " hasn't open or pending cart");
    }
}
