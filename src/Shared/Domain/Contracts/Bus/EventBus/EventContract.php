<?php

namespace Cart\Shared\Domain\Contracts\Bus\EventBus;


interface EventContract
{
    public function serializeArray(): array;
    public function serializeJson(): string;
}
