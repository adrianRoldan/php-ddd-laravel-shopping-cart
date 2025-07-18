<?php

namespace Cart\Core\Cart\Domain\Events;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\Entities\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Events\DomainEvent;

class ProductAddedEvent extends DomainEvent
{
    public static function create(Product $product, CartId $cartId, ProductQuantity $quantity): ProductAddedEvent
    {
        $event = new self($product->id->getValue(), $product->eventStreamName());
        $event->addData([
            "product"   => $product->serialize(),
            "cartId"    => $cartId->getValue(),
            "quantity"  => $quantity->getValue()
        ]);
        return $event;
    }
}
