<?php

namespace Cart\Core\Cart\Domain\Services;

use Cart\Shared\Domain\ValueObjects\Money\Amount;
use Cart\Shared\Domain\ValueObjects\Money\Currency;
use Cart\Shared\Domain\ValueObjects\Money\Money;

interface CurrencyExchangeProviderContract
{
    public function exchangeTo(Amount $amount, Currency $currency): Money;
}
