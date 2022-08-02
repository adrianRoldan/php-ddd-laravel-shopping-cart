<?php

namespace Cart\Core\Product\Domain\Events;

use Cart\Core\Product\Domain\Product;
use Cart\Shared\Domain\Events\DomainEvent;


final class ProductCreatedEvent extends DomainEvent
{
    public static function create(Product $entity): ProductCreatedEvent
    {
        $event = new self($entity->id->getValue(), $entity->eventStreamName());
        $event->addData(array_merge($entity->serialize()));
        return $event;
    }
}
