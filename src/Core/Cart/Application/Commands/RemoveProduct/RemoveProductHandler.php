<?php

namespace Cart\Core\Cart\Application\Commands\RemoveProduct;

use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventBusContract;


class RemoveProductHandler implements CommandHandlerContract
{
    private CartRepositoryContract $cartRepository;
    private ProductRepositoryContract $productRepository;
    private EventBusContract $eventBus;

    /**
     * @param CartRepositoryContract $cartRepository
     * @param ProductRepositoryContract $productRepository
     * @param EventBusContract $eventBus
     */
    public function __construct(CartRepositoryContract $cartRepository, ProductRepositoryContract $productRepository, EventBusContract $eventBus)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }


    public function handle(RemoveProductCommand $command): void
    {
        $product = $this->productRepository->byIdOrFail($command->productId);
        $cart = $this->cartRepository->openByUserOrFail($command->userId);

        $cart->removeProduct($product);

        $this->cartRepository->store($cart);

        $this->eventBus->publish($cart->getEvents());

    }

}
