<?php

namespace Cart\Shared\Domain\ValueObjects\Money;

use Cart\Shared\Domain\Exceptions\ValidationDomainException;
use Cart\Shared\Domain\ValueObjects\ValueObject;

final class Currency extends ValueObject
{
    public const DEFAULT = "EUR";

    private string $value;

    private function __construct(string $value)
    {
        $this->validate($value);
        $this->value = strtoupper($value);
    }

    /**
     * @param string $value
     * @return Currency
     */
    public static function fromValue(string $value): self
    {
        return new self($value);
    }


    /**
     * @return Currency
     */
    public static function fromDefault(): self
    {
        return self::fromValue(self::DEFAULT);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param Currency $otherCurrency
     * @return bool
     */
    public function equals(Currency $otherCurrency): bool
    {
        return $this->value === $otherCurrency->getValue();
    }

    /**
     * @param Currency $otherCurrency
     * @return bool
     */
    public function notEquals(Currency $otherCurrency): bool
    {
        return !$this->equals($otherCurrency);
    }

    /**
     * @param string $value
     * @return void
     */
    private function validate(string $value): void
    {
        if(strlen($value) !== 3){
            throw ValidationDomainException::fromMessage("The Currency $value is incorrect");
        }
    }

}
