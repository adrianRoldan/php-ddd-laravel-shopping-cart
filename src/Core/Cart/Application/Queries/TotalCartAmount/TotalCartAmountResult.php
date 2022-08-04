<?php

namespace Cart\Core\Cart\Application\Queries\TotalCartAmount;

use Cart\Core\Cart\Domain\Dtos\CartMoneyDto;

final class TotalCartAmountResult
{
    public CartMoneyDto $originalCurrency;
    public ?CartMoneyDto $convertedCurrency;

    /**
     * @param CartMoneyDto $originalCurrency
     * @param CartMoneyDto|null $convertedCurrency
     */
    public function __construct(CartMoneyDto $originalCurrency, ?CartMoneyDto $convertedCurrency)
    {
        $this->originalCurrency = $originalCurrency;
        $this->convertedCurrency = $convertedCurrency;
    }
}
