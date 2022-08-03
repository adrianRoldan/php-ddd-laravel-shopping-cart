<?php

namespace Cart\Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Cart\Domain\Repositories\CartRepositoryContract;
use Cart\Core\Product\Domain\Repositories\ProductRepositoryContract;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventBusContract;

class AddProductHandler implements CommandHandlerContract
{

    private EventBusContract $eventBus;
    private ProductRepositoryContract $productRepository;
    private CartRepositoryContract $cartRepository;

    public function __construct(ProductRepositoryContract $productRepository, CartRepositoryContract $cartRepository, EventBusContract $eventBus)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->eventBus = $eventBus;
    }

    public function handle(AddProductCommand $command): void
    {
        $cart = $this->cartRepository->byIdOrFail($command->cartId);
        $product = $this->productRepository->byIdOrFail($command->productId);

        $cart->addProduct($product, $command->quantity);

        $this->cartRepository->store($cart);

        $this->eventBus->publish($product->getEvents());
    }
}
