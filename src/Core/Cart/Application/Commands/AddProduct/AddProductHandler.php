<?php

namespace Cart\Core\Cart\Application\Commands\AddProduct;

use Cart\Core\Product\Infrastructure\Repositories\ProductMapper;
use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;
use Cart\Shared\Domain\Contracts\Bus\EventBus\EventBusContract;
use Tests\Unit\Core\Product\EloquentProductMother;

class AddProductHandler implements CommandHandlerContract
{

    private EventBusContract $eventBus;

    public function __construct(EventBusContract $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function handle(AddProductCommand $command): void
    {

        $product = ProductMapper::hydrate(EloquentProductMother::random());

        $product->hola();

        $this->eventBus->publish($product->getEvents());
        dd($product->serialize());
    }
}
