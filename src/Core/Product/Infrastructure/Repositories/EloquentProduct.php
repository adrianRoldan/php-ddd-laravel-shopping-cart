<?php

namespace Cart\Core\Product\Infrastructure\Repositories;

use Cart\Shared\Infrastructure\Repositories\EloquentBaseModel;

/**
 * @method static make(array|string[] $array_merge)
 * @property string $id
 * @property float $price
 * @property string $name
 * @property string $description
 * @property int $createdAt
 * @property int $updatedAt
 * @property float $priceWithDiscount
 * @property int $minToDiscount
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
        'price',
        'priceWithDiscount',
        'minToDiscount'
    ];
}
