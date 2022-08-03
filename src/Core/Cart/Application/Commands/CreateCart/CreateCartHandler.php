<?php

namespace Cart\Core\Cart\Application\Commands\CreateCart;

use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventBusContract;


class CreateCartHandler implements CommandHandlerContract
{
    private CartRepositoryContract $repository;
    private EventBusContract $eventBus;

    /**
     * @param CartRepositoryContract $repository
     * @param EventBusContract $eventBus
     */
    public function __construct(CartRepositoryContract $repository, EventBusContract $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }


    public function handle(CreateCartCommand $command)
    {
        $cart = Cart::create($command->cartId, $command->userId);

        $this->repository->store($cart);

        $this->eventBus->publish($cart->getEvents());
    }
}
