<?php

namespace Cart\Shared\Domain\ValueObjects\Number;

use Cart\Shared\Domain\Exceptions\ValidationDomainException;

abstract class UnsignedIntegerValueObject
{
    protected int $value;

    protected function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function greaterEqualsThan(self $otherInteger): bool
    {
        return $this->value >= $otherInteger->getValue();
    }

    /**
     * @param int $value
     * @throws ValidationDomainException
     */
    private function validate(int $value): void
    {
        if(!is_numeric($value)) //TODO: never will be false
            throw ValidationDomainException::fromMessage("The $value is not numeric.");

        $options = [
            'options' => [
                'min_range' => 0,
            ]
        ];

        //Validate that is a integer
        if (false == filter_var($value, FILTER_VALIDATE_INT, $options)) {
            throw ValidationDomainException::fromMessage("The number cannot be less than 0");
        }
    }
}
