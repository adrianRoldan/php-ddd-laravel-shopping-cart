<?php

namespace Cart\Core\Cart\Application\Queries\ListCarts;

use Cart\Core\Cart\Domain\Dtos\CartDto;
use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;


class ListCartsHandler implements CommandHandlerContract
{
    private CartRepositoryContract $repository;

    /**
     * @param CartRepositoryContract $repository
     */
    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ListCartsQuery $command
     * @return CartDto[]
     */
    public function handle(ListCartsQuery $command): array
    {
        $carts = $this->repository->all();

        return array_map(static function(Cart $cart){
            return new CartDto($cart->id->getValue(), $cart->userId->getValue(), $cart->products, $cart->status->getValue());
        }, $carts);
    }

}
