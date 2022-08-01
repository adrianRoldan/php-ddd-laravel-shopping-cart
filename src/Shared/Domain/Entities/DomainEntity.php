<?php

namespace Cart\Shared\Domain\Entities;


use Cart\Shared\Domain\DomainSerializer;
use Cart\Shared\Domain\Events\DomainEvent;
use ReflectionClass;

abstract class DomainEntity
{
    /**
     * @var DomainEvent[]
     */
    protected array $domainEvents = [];
    private bool $isNew;

    final protected function __construct()
    {
        $this->setIsNew(true);
    }

    /**
     * Returns an instance of a Domain Entity with its properties filled from an array
     * @param array $array
     * @return static
     */
    public static function hydrate(array $array = []): self
    {
        $entity = new static();
        $entity->setIsNew(false);   //The data already exists in database. then is not a new entity
        $entityProperties = (new ReflectionClass($entity))->getProperties();

        foreach ($array as $key => $item) {

            foreach($entityProperties as $property)
            {
                if($property->name === $key){
                    $entity->{$key} = $item;
                }
            }
        }
        return $entity;
    }


    public function serialize(): array
    {
        $serializer = new DomainSerializer($this);
        return $serializer->serialize();
    }


    final protected function recordEvent(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }


    /**
     * @return DomainEvent[]
     */
    final public function getEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->resetEvents();

        return $domainEvents;
    }


    final public function resetEvents(): void
    {
        $this->domainEvents = [];
    }

    public function eventStreamName(): string
    {
        return static::class. "/". $this->id->getValue();
    }


    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->isNew;
    }

    /**
     * @param bool $isNew
     */
    public function setIsNew(bool $isNew): void
    {
        $this->isNew = $isNew;
    }
}
