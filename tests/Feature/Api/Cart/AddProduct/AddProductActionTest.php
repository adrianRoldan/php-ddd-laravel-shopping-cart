<?php

namespace Api\Cart\AddProduct;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Tests\FakerMother;
use Tests\TestCase;

class AddProductActionTest extends TestCase
{

    public function test_if_add_product_endpoint_works()
    {
        $response = $this->json('post', route('api.cart.product.add'), [
            "productId" => ProductId::random()->getValue(),
            "userId"    => UserId::random()->getValue(),
            "quantity"  => FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT)
        ]);

        //Then
        $response->assertStatus(200);
    }

}
