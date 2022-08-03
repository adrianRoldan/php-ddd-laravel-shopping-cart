<?php

namespace Cart\Core\Cart\Infrastructure\Repositories;

use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Cart\Domain\ValueObjects\CartProduct;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class EloquentCartMapper
{
    /**
     * @param EloquentCart $elCart
     * @param EloquentCartProduct[] $cartProducts
     * @return Cart
     */
    public static function hydrate(EloquentCart $elCart, array $cartProducts): Cart
    {
        $products = [];
        foreach($cartProducts as $cartProduct){
            $products[$cartProduct->productId] = new CartProduct(
                ProductId::create($cartProduct->productId),
                new ProductQuantity($cartProduct->quantity),
                false
            );
        }

        return Cart::hydrate([
            'id'          => CartId::create($elCart->id),
            'userId'      => UserId::create($elCart->userId),
            'status'      => CartStatusEnum::fromValue($elCart->status),
            'products'    => $products
        ]);
    }
}
