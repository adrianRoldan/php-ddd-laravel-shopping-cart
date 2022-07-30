<?php

namespace Cart\Shared\Domain\Contracts\Bus\CommandBus;


interface CommandBusContract
{
    public static function dispatch(CommandContract $command);
}
