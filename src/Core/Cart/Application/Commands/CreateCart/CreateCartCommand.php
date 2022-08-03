<?php

namespace Cart\Core\Cart\Application\Commands\CreateCart;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandContract;

/**
 * @see CreateCartHandler
 */
class CreateCartCommand implements CommandContract
{
    public CartId $cartId;
    public UserId $userId;

    /**
     * @param CartId $cartId
     * @param UserId $userId
     */
    public function __construct(CartId $cartId, UserId $userId)
    {
        $this->cartId = $cartId;
        $this->userId = $userId;
    }
}
