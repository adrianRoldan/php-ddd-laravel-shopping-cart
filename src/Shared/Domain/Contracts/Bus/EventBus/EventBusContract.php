<?php

namespace Cart\Shared\Domain\Contracts\Bus\EventBus;

use Cart\Shared\Domain\Events\DomainEvent;

interface EventBusContract
{
    public function publish(DomainEvent ...$events): void;
}
