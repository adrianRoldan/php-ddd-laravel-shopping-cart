<?php

namespace Shared\Domain\ValueObjects;

use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Exceptions\ValidationDomainException;
use Cart\Shared\Domain\ValueObjects\Number\UnsignedIntegerValueObject;
use PHPUnit\Framework\TestCase;
use TypeError;

class UnsignedIntegerValueObjectTest extends TestCase
{

    public function test_when_value_is_correct()
    {
        //Having
        $value = 4;

        //When
        $valueObject = new ProductQuantity($value);    //Test with this class that extends UnsignedIntegerValueObject (abstract)

        //Then
        $this->assertInstanceOf(UnsignedIntegerValueObject::class, $valueObject);
        $this->assertTrue(is_integer($valueObject->getValue()));   //Check with Ramsey if is a valid uuid
    }


    public function test_with_negative_value()
    {
        //Having
        $signedNum = -2;

        //Then
        $this->expectException(ValidationDomainException::class);
        $this->expectExceptionMessage("The number cannot be less than 0");


        //When
        new ProductQuantity($signedNum);    //Test with this class that extends UnsignedIntegerValueObject (abstract)
    }


    public function test_with_non_numeric_value()
    {
        //Having
        $randValue = "notNumericValue";

        //Then
        $this->expectException(TypeError::class);

        //When
        new ProductQuantity($randValue);  //Test with this class that extends UnsignedIntegerValueObject (abstract)
    }
}
