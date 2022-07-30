<?php

namespace Cart\Shared\Domain\Contracts;

interface UuidProviderContract
{
    public function generateUuid(): string;

    public function isValid(string $value): bool;
}
