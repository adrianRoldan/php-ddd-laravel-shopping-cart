<?php

namespace Cart\Core\Cart\Infrastructure\Services;

use Cart\Core\Cart\Domain\Exceptions\CurrencyNotFoundException;
use Cart\Core\Cart\Domain\Services\CurrencyExchangeProviderContract;
use Cart\Shared\Domain\Contracts\ApiXmlProviderContract;
use Cart\Shared\Domain\ValueObjects\Money\Amount;
use Cart\Shared\Domain\ValueObjects\Money\Currency;
use Cart\Shared\Domain\ValueObjects\Money\Money;

class EuropeanCentralBankCurrencyExchanger implements CurrencyExchangeProviderContract
{
    public const CURRENCY_API_XML_URL = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

    private ApiXmlProviderContract $apiXmlProvider;

    public function __construct(ApiXmlProviderContract $apiXmlProvider)
    {
        $this->apiXmlProvider = $apiXmlProvider;
    }

    /**
     * @param Amount $amount
     * @param Currency $currency
     * @return Money
     */
    public function exchangeTo(Amount $amount, Currency $currency): Money
    {
        $ratesXml = $this->apiXmlProvider->fromUrl(self::CURRENCY_API_XML_URL); // Load data form European Central Bank API

        foreach ($this->searchRate($ratesXml) as $rate) {

            if (Currency::fromValue($this->elementToString($rate['currency']))->equals($currency)) {
                return Money::create($amount->multiplyByFloat($this->elementToFloat($rate['rate'])), $currency);
            }
        }
        //If we get here it means that the api doesn't have the passed currency
        throw CurrencyNotFoundException::fromCurrency($currency);
    }


    private function searchRate($ratesXml)
    {
        return $ratesXml->Cube->Cube->Cube;
    }

    private function elementToString($element): string
    {
        return strtoupper($element->__toString());
    }

    private function elementToFloat($element): float
    {
        return (float) $element;
    }
}
