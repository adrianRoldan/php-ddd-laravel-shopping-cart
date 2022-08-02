<?php

namespace Cart\Core\Product\Domain;

use Cart\Core\Product\Domain\Events\ProductCreatedEvent;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Entities\DomainEntity;

final class Product extends DomainEntity
{
    public ProductId $id;
    public string $name;
    public string $description;
    public float $price;
    public float $priceWithDiscount;
    public ProductQuantity $minToDiscount;

    /**
     * @param ProductId $id
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float $priceWithDiscount
     * @param ProductQuantity $minToDiscount
     * @return Product
     */
    public static function create(ProductId $id, string $name, string $description, float $price, float $priceWithDiscount, ProductQuantity $minToDiscount): Product
    {
        $instance = new self();
        $instance->id = $id;
        $instance->name = $name;
        $instance->description = $description;
        $instance->price = $price;
        $instance->priceWithDiscount = $priceWithDiscount;
        $instance->minToDiscount = $minToDiscount;

        $instance->recordEvent(ProductCreatedEvent::create($instance));

        return $instance;
    }
}
