<?php

namespace Cart\Shared\Infrastructure\Services;

use Cart\Shared\Domain\Contracts\Bus\EventBus\EventDispatcherContract;
use Cart\Shared\Domain\Events\DomainEvent;

class LaravelEventDispatcher implements EventDispatcherContract
{

    public function dispatchEvent(DomainEvent $event): void
    {
        event($event);
    }
}
