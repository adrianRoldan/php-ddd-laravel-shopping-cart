<?php

namespace Cart\Shared\Domain\Contracts\Repositories;


use Cart\Shared\Domain\Events\DomainEvent;

interface DomainEventRepositoryContract
{
    public function store(DomainEvent $event): void;
}
