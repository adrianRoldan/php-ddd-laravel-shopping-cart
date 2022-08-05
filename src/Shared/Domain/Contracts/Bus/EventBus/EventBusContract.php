<?php

namespace Cart\Shared\Domain\Contracts\Bus\EventBus;

use Cart\Shared\Domain\Events\DomainEvent;

interface EventBusContract
{
    /**
     * @param DomainEvent[] $events
     * @return void
     */
    public function publish(array $events): void;
}
