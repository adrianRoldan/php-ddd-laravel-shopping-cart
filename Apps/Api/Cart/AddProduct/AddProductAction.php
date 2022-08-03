<?php

namespace Apps\Api\Cart\AddProduct;

use Apps\Shared\ControllerAction;
use Cart\Core\Cart\Application\Commands\AddProduct\AddProductCommand;
use Cart\Core\Cart\Application\Commands\CreateCart\CreateCartCommand;
use Cart\Core\Cart\Application\Queries\FindOpenCartByUser\FindOpenCartByUserQuery;
use Cart\Core\Cart\Domain\Exceptions\CartNotFoundException;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class AddProductAction extends ControllerAction
{

    public function __invoke(ProductId $productId, ProductQuantity $quantity, UserId $userId)
    {
        try {
            $cart = $this->queryBus->dispatch(new FindOpenCartByUserQuery($userId));
            $cartId = CartId::create($cart->id);

        }catch (CartNotFoundException $e){  //If not exists the cart, we created it
            $cartId = CartId::random();
            $this->commandBus->dispatch(new CreateCartCommand($cartId, $userId));
        }

        $this->commandBus->dispatch(new AddProductCommand($cartId, $productId, $quantity));
    }
}
