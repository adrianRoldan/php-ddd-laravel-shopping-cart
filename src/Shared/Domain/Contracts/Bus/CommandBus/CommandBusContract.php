<?php

namespace Cart\Shared\Domain\Contracts\Bus\CommandBus;


interface CommandBusContract
{
    public function dispatch(CommandContract $command): void;
}
