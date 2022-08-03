<?php

namespace Cart\Core\Cart\Infrastructure\Repositories;

use Cart\Shared\Infrastructure\Repositories\EloquentBaseModel;

/**
 * @property string $id
 * @property string $userId
 * @property string $status
 */
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
