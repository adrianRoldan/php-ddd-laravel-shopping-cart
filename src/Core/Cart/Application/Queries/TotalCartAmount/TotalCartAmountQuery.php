<?php

namespace Cart\Core\Cart\Application\Queries\TotalCartAmount;

use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryContract;
use Cart\Shared\Domain\ValueObjects\Money\Currency;

/**
 * @see TotalCartAmountHandler
 */
class TotalCartAmountQuery implements QueryContract
{
    public UserId $userId;
    public ?Currency $currency;
    public bool $withDiscounts;

    /**
     * @param UserId $userId
     * @param ?Currency $currency
     * @param bool $withDiscounts
     */
    public function __construct(UserId $userId, ?Currency $currency = null, bool $withDiscounts = true)
    {
        $this->userId = $userId;
        $this->currency = $currency;
        $this->withDiscounts = $withDiscounts;
    }
}
