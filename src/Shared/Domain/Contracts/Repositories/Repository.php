<?php

namespace Cart\Shared\Domain\Contracts\Repositories;

use Cart\Shared\Domain\Entities\DomainEntity;

interface Repository
{
    /**
     * @param DomainEntity $domainEntity
     * @param string $className
     * @param array<string, mixed> $data
     * @return void
     */
    public function upsert(DomainEntity $domainEntity, string $className, array $data): void;
}
