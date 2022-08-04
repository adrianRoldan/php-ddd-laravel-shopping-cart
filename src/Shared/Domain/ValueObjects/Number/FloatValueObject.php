<?php

namespace Cart\Shared\Domain\ValueObjects\Number;

use Cart\Shared\Domain\Exceptions\ValidationDomainException;

abstract class FloatValueObject
{
    protected float $value;

    protected function __construct(float $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public static function fromValue(float $value): self
    {
        return new static($value);
    }

    /**
     * @param int $multiplier
     * @return self
     */
    public function multiply(int $multiplier): self
    {
        return self::fromValue($this->value * $multiplier);
    }


    /**
     * @param float $multiplier
     * @return self
     */
    public function multiplyByFloat(float $multiplier): self
    {
        return self::fromValue(round($this->value * $multiplier, 2));
    }

    /**
     * @param float $value
     * @throws ValidationDomainException
     */
    private function validate(float $value): void
    {
        if(!is_numeric($value)) //TODO: never will be false
            throw ValidationDomainException::fromMessage("The $value is not numeric.");

        $options = [
            'options' => [
                'min_range' => 0,
            ]
        ];

        //Validate that is a float
        if (false === filter_var($value, FILTER_VALIDATE_FLOAT, $options)) {
            throw ValidationDomainException::fromMessage("$value is a incorrect number");
        }
    }
}
