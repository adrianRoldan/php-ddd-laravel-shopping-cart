<?php

namespace Cart\Core\Product\Domain\ValueObjects;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Cart\Domain\Exceptions\MaxQuantityExceededPerProductException;
use Cart\Shared\Domain\Exceptions\ValidationDomainException;
use Cart\Shared\Domain\ValueObjects\UnsignedIntegerValueObject;

final class ProductQuantity extends UnsignedIntegerValueObject
{
    /**
     * UserEmail constructor.
     * @param int $value
     * @throws ValidationDomainException
     */
    public function __construct(int $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    /**
     * @param ProductQuantity $quantity
     * @return ProductQuantity
     */
    public function sum(ProductQuantity $quantity): self
    {
        return new self($this->getValue() + $quantity->getValue());
    }

    /**
     * @param int $value
     * @throws ValidationDomainException
     */
    private function validate(int $value): void
    {
        if($value > CartSettings::MAX_PER_PRODUCT){
            throw MaxQuantityExceededPerProductException::fromQuantity($this);
        }
    }
}
