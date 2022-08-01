<?php

namespace Cart\Shared\Domain\Contracts\Bus\EventBus;


interface EventBusContract
{
    public function publish(array $events): void;
}
