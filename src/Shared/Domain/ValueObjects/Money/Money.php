<?php

namespace Cart\Shared\Domain\ValueObjects\Money;

use Cart\Shared\Domain\ValueObjects\ValueObject;

class Money extends ValueObject
{
    public Amount $amount;
    public Currency $currency;

    private function __construct(Amount $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @param Amount $amount
     * @param Currency|null $currency
     * @return Money
     */
    public static function create(Amount $amount, ?Currency $currency = null): Money
    {
        return new self($amount, $currency ?? Currency::fromValue(Currency::DEFAULT));
    }


    /**
     * @param Currency|null $currency
     * @return Money
     */
    public static function createEmpty(?Currency $currency = null): Money
    {
        return new self(Amount::fromValue(0), $currency ?? Currency::fromValue(Currency::DEFAULT));
    }

    /**
     * @param float $number
     * @param Currency|null $currency
     * @return Money
     */
    public static function fromFloat(float $number, ?Currency $currency = null): Money
    {
        return new self(Amount::fromValue($number), $currency ?? Currency::fromValue(Currency::DEFAULT));
    }


    /**
     * @param float $priceAmount
     * @param string $fromValue
     * @return Money
     */
    public static function fromValues(float $priceAmount, string $fromValue): Money
    {
        return new self(Amount::fromValue($priceAmount), Currency::fromValue($fromValue));
    }


    /**
     * @param Money $moneyToSum
     * @return Money
     */
    public function sum(Money $moneyToSum): Money
    {
        return self::fromFloat($this->getAmountValue() + $moneyToSum->getAmountValue(), $this->currency);
    }


    /**
     * @param int $multiplier
     * @return Money
     */
    public function multiply(int $multiplier): Money
    {
        return self::create($this->amount->multiply($multiplier), $this->currency);
    }


    /**
     * @return float
     */
    public function getAmountValue(): float
    {
        return $this->amount->getValue();
    }


}
