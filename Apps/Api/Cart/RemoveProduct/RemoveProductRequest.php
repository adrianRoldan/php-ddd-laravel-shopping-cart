<?php

namespace Apps\Api\Cart\RemoveProduct;

use Apps\Shared\Http\Request\AbstractFormRequest;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class RemoveProductRequest extends AbstractFormRequest
{
    public function getUserId(): UserId
    {
        $helper = $this->getHelper();
        return UserId::create($helper->getRequiredString('userId'));
    }

    public function getProductId(): ProductId
    {
        $helper = $this->getHelper();
        return ProductId::create($helper->getRequiredString('productId'));
    }
}
