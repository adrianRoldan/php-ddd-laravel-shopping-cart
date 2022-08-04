<?php

namespace Apps\Api\Cart\TotalAmount;

use Apps\Shared\ControllerAction;
use Cart\Core\Cart\Application\Queries\TotalCartAmount\TotalCartAmountQuery;
use Cart\Core\Cart\Application\Queries\TotalCartAmount\TotalCartAmountResult;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\ValueObjects\Money\Currency;

final class TotalCartAmountAction extends ControllerAction
{
    public function __invoke(UserId $userId, ?Currency $currency): TotalCartAmountResource
    {
        /** @var TotalCartAmountResult $totalWithDiscounts */
        $totalWithDiscounts = $this->queryBus->dispatch(new TotalCartAmountQuery($userId, $currency));

        /** @var TotalCartAmountResult $totalWithoutDiscounts */
        $totalWithoutDiscounts = $this->queryBus->dispatch(new TotalCartAmountQuery($userId, $currency, false));

        return new TotalCartAmountResource(
            $totalWithDiscounts,
            $totalWithoutDiscounts
        );
    }
}
