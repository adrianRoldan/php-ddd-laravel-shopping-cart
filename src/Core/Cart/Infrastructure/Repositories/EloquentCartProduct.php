<?php

namespace Cart\Core\Cart\Infrastructure\Repositories;

use Cart\Shared\Infrastructure\Repositories\EloquentBaseModel;

/**
 * @property string $productId
 * @property string $cartId
 * @property int $quantity
 * @method static self create(array $array)
 */
final class EloquentCartProduct extends EloquentBaseModel
{
    /** @var string $table */
    protected $table = "cart_products";

    /** @var string[] */
    protected $fillable = [
        'cartId',
        'productId',
        'quantity'
    ];
}
