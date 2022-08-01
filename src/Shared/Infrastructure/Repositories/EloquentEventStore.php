<?php

namespace Cart\Shared\Infrastructure\Repositories;

use Cart\Shared\Domain\Contracts\Repositories\DomainEventRepositoryContract;
use Cart\Shared\Domain\Events\DomainEvent;

class EloquentEventStore extends EloquentBaseRepository implements DomainEventRepositoryContract
{

    public function store(DomainEvent $event): void
    {
        EloquentDomainEvent::query()->create($event->serializeArray());
    }
}
