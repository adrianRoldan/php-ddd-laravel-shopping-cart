<?php

namespace Cart\Shared\Domain\Contracts\Repositories;

use Cart\Shared\Domain\Entities\DomainEntity;

interface Repository
{
    public function upsert(DomainEntity $domainEntity, string $className, array $data): void;
}
