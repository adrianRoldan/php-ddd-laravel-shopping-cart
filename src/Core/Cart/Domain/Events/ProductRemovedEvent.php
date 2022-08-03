<?php

namespace Cart\Core\Cart\Domain\Events;

use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\Product;
use Cart\Shared\Domain\Events\DomainEvent;

class ProductRemovedEvent extends DomainEvent
{
    public static function create(Product $product, CartId $cartId): ProductRemovedEvent
    {
        $event = new self($product->id->getValue(), $product->eventStreamName());
        $event->addData([
            "product"   => $product->serialize(),
            "cartId"    => $cartId->getValue()
        ]);
        return $event;
    }
}
