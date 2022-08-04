<?php

namespace Cart\Core\Cart\Domain\Dtos;

final class CartMoneyDto
{
    public string $currency;
    public float $price;

    /**
     * @param float $price
     * @param string $currency
     */
    public function __construct(float $price, string $currency)
    {
        $this->currency = $currency;
        $this->price = $price;
    }
}
