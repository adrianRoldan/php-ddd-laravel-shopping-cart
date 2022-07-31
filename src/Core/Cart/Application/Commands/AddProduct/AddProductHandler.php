<?php

namespace Cart\Core\Cart\Application\Commands\AddProduct;

use Cart\Shared\Domain\Contracts\Bus\CommandBus\CommandHandlerContract;

class AddProductHandler implements CommandHandlerContract
{

    public function handle(AddProductCommand $command): void
    {
        dd("asdasdasd");
    }
}
