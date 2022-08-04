<?php

namespace Apps\Api\Cart\TotalAmount;

use Apps\Shared\Http\Request\AbstractFormRequest;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\ValueObjects\Money\Currency;

final class TotalCartAmountRequest extends AbstractFormRequest
{

    public function getUserId(): UserId
    {
        $helper = $this->getHelper();
        return UserId::create($helper->routeString('userId'));
    }

    public function getCurrencyOrNull(): ?Currency
    {
        $helper = $this->getHelper();
        $currencyStr = $helper->routeStringOrNull('currency');
        if(null === $currencyStr){
            return null;
        }
        return Currency::fromValue($currencyStr);
    }
}
