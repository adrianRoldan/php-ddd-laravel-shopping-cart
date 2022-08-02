<?php

namespace Cart\Core\Cart\Infrastructure\Repositories;

use Cart\Shared\Infrastructure\Repositories\EloquentBaseModel;

final class EloquentCart extends EloquentBaseModel
{
    /** @var string $table */
    protected $table = "carts";

    /** @var string[] */
    protected $fillable = [
        'id',
        'userId',
        'status'
    ];
}
