<?php

namespace Cart\Core\Cart\Domain\Events;

use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Shared\Domain\Events\DomainEvent;

class CartCreatedEvent extends DomainEvent
{
    public static function create(Cart $entity): CartCreatedEvent
    {
        $event = new self($entity->id->getValue(), $entity->eventStreamName());
        $event->addData($entity->serialize());
        return $event;
    }
}
