<?php

namespace Cart\Core\Cart\Domain\Exceptions;

use Cart\Shared\Domain\Exceptions\BaseDomainException;
use Cart\Shared\Domain\ValueObjects\Money\Currency;

class CurrencyNotFoundException extends BaseDomainException
{
    /**
     * @param Currency $currency
     * @return static
     */
    public static function fromCurrency(Currency $currency): self
    {
        return new self("Not exists this currency ".$currency->getValue());
    }
}
