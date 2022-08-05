<?php

namespace Tests\Unit\Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Cart\Application\Commands\AddProduct\AddProductCommand;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Exception;
use Tests\FakerMother;

class AddProductCommandMother
{
    /**
     * @throws Exception
     */
    public static function random(array $params = []): AddProductCommand
    {
        $params = array_merge([
            'cartId'      => CartId::random(),
            'productId'   => ProductId::random(),
            'quantity'    => new ProductQuantity(FakerMother::quantity(1, 4))
        ], $params);

        return new AddProductCommand(
            $params['cartId'],
            $params['productId'],
            $params['quantity']
        );
    }
}
