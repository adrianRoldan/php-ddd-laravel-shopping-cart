<?php

namespace Cart\Shared\Domain\Contracts;

use DomainException;

interface DomainExceptionContract
{
    public static function fromMessage(string $message): static;
}
