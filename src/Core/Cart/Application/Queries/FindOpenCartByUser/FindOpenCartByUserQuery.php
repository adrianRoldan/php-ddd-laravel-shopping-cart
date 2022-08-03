<?php

namespace Cart\Core\Cart\Application\Queries\FindOpenCartByUser;

use Cart\Core\User\Domain\ValueObjects\UserId;
use Cart\Shared\Domain\Contracts\Bus\QueryBus\QueryContract;

/**
 * @see FindOpenCartByUserHandler
 */
class FindOpenCartByUserQuery implements QueryContract
{
    public UserId $userId;

    /**
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }
}
