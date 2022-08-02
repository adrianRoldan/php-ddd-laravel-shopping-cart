<?php

namespace Cart\Shared\Domain\ValueObjects;

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


    /**
     * @param int $value
     * @throws ValidationDomainException
     */
    private function validate(int $value): void
    {
        if(!is_numeric($value))
            throw ValidationDomainException::fromMessage("The $value is not numeric.");

        $options = array(
            'options' => array(
                'min_range' => 0,
            )
        );

        //Validate that is a integer
        if (!filter_var($value, FILTER_VALIDATE_INT, $options)) {
            throw ValidationDomainException::fromMessage("The number cannot be less than 0");
        }
    }
}
