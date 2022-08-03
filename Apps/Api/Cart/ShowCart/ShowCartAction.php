<?php

namespace Apps\Api\Cart\ShowCart;

use Apps\Shared\ControllerAction;
use Cart\Core\Cart\Application\Queries\FindOpenCartByUser\FindOpenCartByUserQuery;
use Cart\Core\Cart\Domain\Dtos\CartDto;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class ShowCartAction extends ControllerAction
{
    /**
     * @param UserId $userId
     * @return ShowCartResource
     */
    public function __invoke(UserId $userId): ShowCartResource
    {
        /** @var CartDto $cart */
        $cart = $this->queryBus->dispatch(new FindOpenCartByUserQuery($userId));

        return new ShowCartResource($cart);
    }
}
