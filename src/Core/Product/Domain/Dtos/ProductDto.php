<?php

namespace Cart\Core\Product\Domain\Dtos;

final class ProductDto
{
    public string $id;
    public string $name;
    public string $description;
    public float $price;
    public float $priceWithDiscount;
    public int $minToDiscount;

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float $priceWithDiscount
     * @param int $minToDiscount
     */
    public function __construct(string $id, string $name, string $description, float $price, float $priceWithDiscount, int $minToDiscount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->priceWithDiscount = $priceWithDiscount;
        $this->minToDiscount = $minToDiscount;
    }
}
