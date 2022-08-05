<?php

namespace Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Cart\Infrastructure\Repositories\EloquentCartProduct;
use Cart\Core\Product\Domain\Exceptions\ProductNotFoundException;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Shared\Infrastructure\Bus\CommandBus;
use Cart\Shared\Infrastructure\Services\LaravelDependencyContainer;
use Exception;
use Tests\TestCase;
use Tests\Unit\Core\Cart\Application\Commands\AddProduct\AddProductCommandMother;
use Tests\Unit\Core\Cart\EloquentCartMother;
use Tests\Unit\Core\Product\EloquentProductMother;

class AddProductHandlerTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test_add_product_command_works()
    {
        //Having
        $elCart = EloquentCartMother::random(['status', CartStatusEnum::open()->getValue()]);
        $elProduct = EloquentProductMother::random();
        $quantity = new ProductQuantity(3);

        $command = AddProductCommandMother::random([
            'cartId' => CartId::create($elCart->id),
            'productId' => ProductId::create($elProduct->id),
            'quantity' => $quantity
        ]);

        $commandBus = new CommandBus(new LaravelDependencyContainer());

        //When
        $commandBus->dispatch($command);

        //Then
        $cartProducts = EloquentCartProduct::query()->where('cartId', $elCart->id)->get()->all();
        $this->assertCount(1, $cartProducts);
        $this->assertEquals($elProduct->id, $cartProducts[0]->productId);
        $this->assertEquals($elCart->id, $cartProducts[0]->cartId);
        $this->assertEquals($quantity->getvalue(), $cartProducts[0]->quantity);
    }


    public function test_add_product_not_works_when_product_not_exists()
    {
        //Having
        $elCart = EloquentCartMother::random(['status', CartStatusEnum::open()->getValue()]);
        $quantity = new ProductQuantity(3);

        $command = AddProductCommandMother::random([
            'cartId' => CartId::create($elCart->id),
            'productId' => ProductId::random(),
            'quantity' => $quantity
        ]);

        $commandBus = new CommandBus(new LaravelDependencyContainer());

        //then
        $this->expectException(ProductNotFoundException::class);

        //When
        $commandBus->dispatch($command);
    }
}
