<?php

namespace Cart\Shared\Domain\Events;

use Cart\Shared\Domain\Contracts\Bus\EventBus\EventContract;
use Cart\Shared\Domain\DomainSerializer;

abstract class DomainEvent implements EventContract
{
    public DomainEventId $id;
    public string $eventName;
    public string $relatedId;
    public int $occurredOn;
    public string $data;
    public ?string $stream;

    /**
     * @param string $relatedId
     * @param string|null $stream
     */
    final protected function __construct(string $relatedId, ?string $stream)
    {
        $this->id = DomainEventId::random();
        $this->eventName = get_called_class();
        $this->relatedId = $relatedId;
        $this->occurredOn = (int)floor(microtime(true) * 1000);
        $this->data = "";
        $this->stream = $stream;
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function addData(array $data): void
    {
        $this->data = json_encode($data);
    }


    /**
     * @return array<string,mixed>
     */
    public function serializeArray(): array
    {
        $serializer = new DomainSerializer($this);
        return $serializer->serialize();
    }


    public function serializeJson(): string
    {
        $serializer = new DomainSerializer($this);
        return $serializer->serializeJson();
    }
}
