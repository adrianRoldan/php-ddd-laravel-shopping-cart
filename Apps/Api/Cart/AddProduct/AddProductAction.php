<?php

namespace Apps\Api\Cart\AddProduct;

use Apps\Shared\ControllerAction;
use Cart\Core\Cart\Application\Commands\AddProduct\AddProductCommand;
use Cart\Core\Product\Domain\ValueObjects\ProductId;

final class AddProductAction extends ControllerAction
{

    public function __invoke(ProductId $productId, int $quantity)
    {
        $this->commandBus->dispatch(new AddProductCommand($productId, 4));
    }
}
