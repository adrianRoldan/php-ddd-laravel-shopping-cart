<?php

namespace Core\Cart\Application\Commands\AddProduct;

use PHPUnit\Framework\TestCase;
use Tests\Unit\Core\Product\EloquentProductMother;

class AddProductHandlerTest extends TestCase
{
    public function test_add_product_command_works()
    {
        //Having
        $product1 = EloquentProductMother::random();
        $cart = EloquentCartMother::random();

        //When



        //Then
    }
}
