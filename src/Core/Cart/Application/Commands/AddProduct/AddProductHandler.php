<?php

namespace Cart\Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Product\Infrastructure\Repositories\ProductMapper;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Tests\Unit\Core\Product\EloquentProductMother;

class AddProductHandler implements CommandHandlerContract
{

    public function handle(AddProductCommand $command): void
    {

        $product = ProductMapper::hydrate(EloquentProductMother::random());

        dd($product->serialize());
    }
}
