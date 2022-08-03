<?php

namespace Cart\Core\Cart\Domain\Enums;

use Cart\Shared\Domain\Enums\DomainEnum;

/**
 * @method static static open()
 * @method static static pending()
 * @method static static abandoned()
 * @method static static finished()
 * @method static static cleaned()
 */
class CartStatusEnum extends DomainEnum
{
    public const OPEN = 'open';   //The cart has been initialized
    public const PENDING = 'pending';   //The cart has at least a product
    public const ABANDONED = 'abandoned';   //Has been pending for a long time
    public const FINISHED = 'finished';     //The cart has been purchased
    public const CLEANED = 'cleaned';   //The user has removed all products from the cart
}
