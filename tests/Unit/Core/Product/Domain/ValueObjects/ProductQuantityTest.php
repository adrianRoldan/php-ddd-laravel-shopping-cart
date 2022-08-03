<?php

namespace Core\Product\Domain\ValueObjects;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Domain\Exceptions\ValidationDomainException;
use Tests\TestCase;
use Tests\FakerMother;

class ProductQuantityTest extends TestCase
{
    public function test_create_product_quantity_works()
    {
        //Having
        $value = FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT);

        //When
        $quantity = new ProductQuantity($value);

        // Then
        $this->assertInstanceOf(ProductQuantity::class, $quantity);
        $this->assertEquals($value, $quantity->getValue());
    }


    public function test_create_product_quantity_with_0()
    {
        //Having
        $value = 0;

        // Then
        $this->expectException(ValidationDomainException::class);
        $this->expectExceptionMessage("At least you must indicate 1 unit");

        //When
        new ProductQuantity($value);
    }
}
