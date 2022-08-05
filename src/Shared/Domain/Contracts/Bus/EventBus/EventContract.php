<?php

namespace Cart\Shared\Domain\Contracts\Bus\EventBus;


interface EventContract
{
    /**
     * @return array<string,mixed>
     */
    public function serializeArray(): array;
    public function serializeJson(): string;
}
