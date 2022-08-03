<?php

namespace Apps\Api\Cart\ListCarts;

use Apps\Shared\ControllerAction;
use Cart\Core\Cart\Application\Queries\ListCarts\ListCartsQuery;
use Cart\Core\Cart\Domain\Dtos\CartDto;

class ListCartsAction extends ControllerAction
{
    /**
     * @return ListCartsResource
     */
    public function __invoke(): ListCartsResource
    {
        /** @var CartDto[] $carts */
        $carts = $this->queryBus->dispatch(new ListCartsQuery());

        return new ListCartsResource($carts);
    }
}
