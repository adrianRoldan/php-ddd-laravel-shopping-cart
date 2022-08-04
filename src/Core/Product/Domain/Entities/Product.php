<?php

namespace Cart\Core\Product\Domain\Entities;

use Cart\Core\Product\Domain\Events\ProductCreatedEvent;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Entities\DomainEntity;
use Cart\Shared\Domain\ValueObjects\Money\Amount;
use Cart\Shared\Domain\ValueObjects\Money\Money;

final class Product extends DomainEntity
{
    public ProductId $id;
    public string $name;
    public string $description;
    public Money $price;
    public Amount $priceWithDiscount;
    public ProductQuantity $minForDiscount;

    /**
     * @param ProductId $id
     * @param string $name
     * @param string $description
     * @param Money $price
     * @param Amount $priceWithDiscount
     * @param ProductQuantity $minForDiscount
     * @return Product
     */
    public static function create(ProductId $id, string $name, string $description, Money $price, Amount $priceWithDiscount, ProductQuantity $minForDiscount): Product
    {
        $instance = new self();
        $instance->id = $id;
        $instance->name = $name;
        $instance->description = $description;
        $instance->price = $price;
        $instance->priceWithDiscount = $priceWithDiscount;
        $instance->minForDiscount = $minForDiscount;

        $instance->recordEvent(ProductCreatedEvent::create($instance));

        return $instance;
    }


    /**
     * @param ProductQuantity $quantity
     * @param bool $withDiscounts
     * @return Money
     */
    public function price(ProductQuantity $quantity, bool $withDiscounts = true): Money
    {
        if(!$withDiscounts){
            return $this->price;
        }

        if($quantity->greaterEqualsThan($this->minForDiscount)){
            return Money::create($this->priceWithDiscount, $this->price->currency); //Same price currency for price with discount
        }

        return $this->price;
    }
}
