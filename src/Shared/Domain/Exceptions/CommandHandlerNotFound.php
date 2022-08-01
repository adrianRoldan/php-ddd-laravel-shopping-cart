<?php

namespace Cart\Shared\Domain\Exceptions;

class CommandHandlerNotFound extends BaseDomainException
{

    public static function fromCommandClass(string $commandClass): self
    {
        return new self('Command handler not found for ' . $commandClass);
    }

    public static function fromMessage(string $message): self
    {
        return new self($message);
    }
}
