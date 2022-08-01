<?php

namespace Cart\Core\Product\Domain;

use Cart\Core\Cart\Domain\Events\ProductAddedEvent;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Domain\Entities\DomainEntity;

final class Product extends DomainEntity
{

    public ProductId $id;
    public string $name;
    public string $description;
    public float $price;

    public function hola()
    {
        $this->recordEvent(ProductAddedEvent::create($this));
    }
}
