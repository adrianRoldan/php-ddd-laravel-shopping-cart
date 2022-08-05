<?php

namespace Tests\Unit\Core\Cart;

use Cart\Core\Cart\Domain\Enums\CartStatusEnum;
use Cart\Core\Cart\Domain\ValueObjects\CartId;
use Cart\Core\Cart\Infrastructure\Repositories\EloquentCart;
use Cart\Core\User\Domain\ValueObjects\UserId;
use Exception;

final class EloquentCartMother
{
    /**
     * @throws Exception
     */
    public static function random(array $params = []): EloquentCart
    {
        $eloquentCart = EloquentCart::make(
            array_merge([
                'id'     => CartId::random()->getValue(),
                'userId' => UserId::random()->getValue(),
                'status' => CartStatusEnum::random()->getValue(),
            ], $params)
        );

        $eloquentCart->save();
        return $eloquentCart;
    }
}
