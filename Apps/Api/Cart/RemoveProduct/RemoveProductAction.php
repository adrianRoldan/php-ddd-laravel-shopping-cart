<?php

namespace Apps\Api\Cart\RemoveProduct;

use Apps\Shared\ControllerAction;
use Cart\Core\Cart\Application\Commands\RemoveProduct\RemoveProductCommand;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class RemoveProductAction extends ControllerAction
{
    public function __invoke(ProductId $productId, UserId $userId): void
    {
        $this->commandBus->dispatch(new RemoveProductCommand($productId, $userId));
    }
}
