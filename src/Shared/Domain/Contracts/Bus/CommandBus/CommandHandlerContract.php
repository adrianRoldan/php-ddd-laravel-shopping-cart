<?php

namespace Cart\Shared\Domain\Contracts\Bus\CommandBus;

interface CommandHandlerContract
{
    public static function handle(CommandContract $command);
}
