<?php

namespace Cart\Shared\Infrastructure\Bus;

use Cart\Shared\Domain\Contracts\Bus\EventBus\EventBusContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventDispatcherContract;
use Cart\Shared\Domain\Contracts\Repositories\DomainEventRepositoryContract;
use Cart\Shared\Domain\Events\DomainEvent;
use Cart\Shared\Domain\Exceptions\EventDispatcherException;
use Throwable;

final class EventBus implements EventBusContract
{
    private EventDispatcherContract $eventDispatcher;
    private DomainEventRepositoryContract $eventStore;

    /**
     * @param EventDispatcherContract $eventDispatcher
     * @param DomainEventRepositoryContract $eventStore
     */
    public function __construct(EventDispatcherContract $eventDispatcher, DomainEventRepositoryContract $eventStore)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventStore = $eventStore;
    }


    /**
     * @param DomainEvent[] $events
     * @return void
     */
    public function publish(array $events): void
    {
        foreach($events as $event)
        {
            try{
                $this->storeEvent($event);
                $this->eventDispatcher->dispatchEvent($event);

            }catch(Throwable $exception){
                throw EventDispatcherException::fromMessage("Error dispatching events. ".$exception->getMessage());
            }
        }
    }

    /**
     * @param DomainEvent $event
     * @return void
     */
    private function storeEvent(DomainEvent $event): void
    {
        $this->eventStore->store($event);
    }
}
