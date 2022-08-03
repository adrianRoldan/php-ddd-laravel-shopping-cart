<?php

namespace Cart\Core\Cart\Domain\Repositories;

use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\User\Domain\ValueObjects\UserId;

interface CartRepositoryContract
{
    public function store(Cart $cart): void;

    public function byIdOrFail(CartId $cartId): Cart;

    public function openByUserOrFail(UserId $userId): Cart;

    /**
     * @return Cart[]
     */
    public function all(): array;
}
