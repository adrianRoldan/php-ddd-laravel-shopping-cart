<?php

namespace Core\Product\Domain\ValueObjects;

use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Shared\Domain\Exceptions\ValidationUuidException;
use Ramsey\Uuid\Uuid;
use Tests\FakerMother;
use Tests\TestCase;

class ProductIdTest extends TestCase
{
    public function test_random_product_id_works()
    {
        //Having && when
        $productId = ProductId::random();

        // Then
        $this->assertInstanceOf(ProductId::class, $productId);
        $this->assertTrue(Uuid::isValid($productId->getValue()));   //Check with Ramsey if is a valid uuid
    }


    public function test_create_from_value_works()
    {
        //Having
        $uuid = FakerMother::uuid(); //Generate a uuid

        //When
        $productId = ProductId::create($uuid);

        // Then
        $this->assertInstanceOf(ProductId::class, $productId);
        $this->assertTrue(Uuid::isValid($productId->getValue()));   //Check with Ramsey if is a valid uuid
    }


    public function test_create_from_incorrect_value()
    {
        //Having
        $uuid = "incorrect uuid";

        //Then
        $this->expectException(ValidationUuidException::class);
        $this->expectExceptionMessage("The Unique Universal ID ($uuid) don't has the correct format");

        //When
        ProductId::create($uuid);
    }


    public function test_create_from_empty_value()
    {
        //Then
        $this->expectException(ValidationUuidException::class);
        $this->expectExceptionMessage("The ID is required");

        //Having
        $uuid = "";

        //When
        ProductId::create($uuid);
    }
}
