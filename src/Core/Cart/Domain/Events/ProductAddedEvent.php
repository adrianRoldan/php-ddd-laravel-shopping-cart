<?php

namespace Cart\Core\Cart\Domain\Events;

use Cart\Core\Product\Domain\Product;
use Cart\Shared\Domain\Events\DomainEvent;

class ProductAddedEvent extends DomainEvent
{
    public static function create(Product $product): ProductAddedEvent
    {
        $event = new self($product->id->getValue(), $product->eventStreamName());
        $event->addData(array_merge($product->serialize(), ["quantity" => 2]));
        return $event;
    }
}
