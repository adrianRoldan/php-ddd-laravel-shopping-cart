<?php

namespace Cart\Core\Cart\Application\Queries\FindOpenCartByUser;

use Cart\Core\Cart\Domain\Dtos\CartDto;
use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryHandlerContract;

class FindOpenCartByUserHandler implements QueryHandlerContract
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
     * @param FindOpenCartByUserQuery $query
     * @return CartDto
     */
    public function handle(FindOpenCartByUserQuery $query): CartDto
    {
        $cart = $this->repository->openByUserOrFail($query->userId);

        return new CartDto(
            $cart->id->getValue(),
            $cart->userId->getValue(),
            $cart->products,
            $cart->status->getValue()
        );
    }
}
