<?php

namespace Core\Cart\Domain\Entities;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Cart\Domain\Entities\Cart;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\Product;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Mockery;
use Tests\TestCase;
use Tests\FakerMother;

class CartTest extends TestCase
{

    public function test_add_product_works()
    {
        //Having
        $cart = Cart::create(CartId::random(), UserId::random());
        $product = Product::create(
            ProductId::random(),
            FakerMother::productName(),
            FakerMother::text(45),
            FakerMother::price(50),
            FakerMother::price(40),
            new ProductQuantity(4)
        );

        //When
        $cart->addProduct($product, new ProductQuantity(2));

        //Then
        $this->assertEquals(1, $cart->countProducts());
    }


    public function test_add_product_when_exceeds_products()
    {
        $mock = Mockery::mock('CartSettings', 'CartSettingsStub');

        $this->instance(CartSettings::class, $this->createMock(CartSettingsStub::class));


        dd(CartSettings::MAX_PER_PRODUCT);

    }
}


interface CartSettingsStub
{
    const MAX_PER_PRODUCT = 2;
    const MAX_DIFFERENT_PRODUCTS = 5;
}
