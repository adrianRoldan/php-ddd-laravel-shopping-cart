<?php

namespace Cart\Core\Product\Infrastructure\Repositories;

use Cart\Shared\Infrastructure\Repositories\EloquentBaseModel;

/**
 * @method static make(array|string[] $array_merge)
 */
final class EloquentProduct extends EloquentBaseModel
{
    /** @var string $table */
    protected $table = "products";

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'description',
        'price'
    ];
}
