<?php

namespace Cart\Shared\Domain\Contracts\Bus\EventBus;

use Cart\Shared\Domain\Events\DomainEvent;

interface EventDispatcherContract
{
    public function dispatchEvent(DomainEvent $event): void;
}
