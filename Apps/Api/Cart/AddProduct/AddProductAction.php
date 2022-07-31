<?php

namespace Apps\Api\Cart\AddProduct;

use Cart\Core\Cart\Application\Commands\AddProduct\AddProductCommand;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandBusContract;

final class AddProductAction
{
    private CommandBusContract $bus;

    /**
     * @param CommandBusContract $bus
     */
    public function __construct(CommandBusContract $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(ProductId $productId, int $quantity)
    {
        $this->bus->dispatch(new AddProductCommand($productId, 4));
    }
}
