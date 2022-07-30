<?php

namespace Cart\Shared\Infrastructure\Services;

use Cart\Shared\Domain\Contracts\UuidProviderContract;
use Ramsey\Uuid\Uuid;

/**
 * Class that implements Ramsey Uuid generator provider
 *
 * Class RamseyUuidProvider
 * @package Src\Shared\Auth\Infrastructure\Services
 */
class RamseyUuidProvider implements UuidProviderContract
{
    /**
     * @return string
     */
    public function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function isValid(string $value): bool
    {
        return Uuid::isValid($value);
    }
}
