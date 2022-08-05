<?php

namespace Api\Cart\AddProduct;

use Cart\Core\Cart\Domain\CartSettings;
use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Exception;
use Tests\FakerMother;
use Tests\TestCase;
use Tests\Unit\Core\Cart\EloquentCartMother;
use Tests\Unit\Core\Product\EloquentProductMother;

class AddProductActionTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test_if_add_product_endpoint_works()
    {
        $elProduct = EloquentProductMother::random();  //Create a product

        $response = $this->json('post', route('api.cart.product.add'), [
            "productId" => $elProduct->id,
            "userId"    => UserId::random()->getValue(),
            "quantity"  => FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT)
        ]);

        //Then
        $response->assertStatus(200);
    }



    /**
     * @throws Exception
     */
    public function test_if_add_product_endpoint_works_and_save_data()
    {
        //Having
        $elProduct = EloquentProductMother::random();  //Create a product
        $userId = UserId::random()->getValue();
        $elCart = EloquentCartMother::random(['userId' => $userId, 'status' => CartStatusEnum::open()->getValue()]);  //Create a cart for user
        $quantity = FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT);

        //When
        $response = $this->json('post', route('api.cart.product.add'), [
            "productId" => $elProduct->id,
            "userId"    => $userId,
            "quantity"  => $quantity
        ]);

        //Then
        $response->assertStatus(200);
        $this->assertDatabaseHas("cart_products", [
            'productId'    => $elProduct->id,
            'cartId'       => $elCart->id,
            'quantity'     => $quantity
        ]);
    }


    /**
     * @throws Exception
     */
    public function test_add_product_endpoint_without_product()
    {
        $response = $this->json('post', route('api.cart.product.add'), [
            "userId"    => UserId::random()->getValue(),
            "quantity"  => FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT)
        ]);

        //Then
        $response->assertStatus(422);
    }


    /**
     * @throws Exception
     */
    public function test_add_product_endpoint_when_product_not_exitst()
    {
        $response = $this->json('post', route('api.cart.product.add'), [
            "productId" => ProductId::random()->getValue(),
            "userId"    => UserId::random()->getValue(),
            "quantity"  => FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT)
        ]);

        //Then
        $response->assertStatus(404);
    }

    /**
     * @throws Exception
     */
    public function test_add_product_endpoint_when_wrong_request()
    {
        //having & when
        $response = $this->json('post', route('api.cart.product.add'), [
            'inventedKeyxxxxxx' => ProductId::random()->getValue(),
            "userId"    => UserId::random()->getValue(),
            "quantity"  => FakerMother::quantity(1, CartSettings::MAX_PER_PRODUCT)
        ]);

        //Then
        $response->assertStatus(422);
    }


    public function test_add_product_endpoint_when_empty_body_request()
    {
        //having & when
        $response = $this->json('post', route('api.cart.product.add'));
        //Then
        $response->assertStatus(422);
    }


    public function test_add_product_endpoint_when_http_method_incorrect()
    {
        //having & when
        $response = $this->json('put', route('api.cart.product.add'));

        //Then
        $response->assertStatus(405);
    }

}
