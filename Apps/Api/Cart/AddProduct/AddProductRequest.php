<?php

namespace Apps\Api\Cart\AddProduct;

use Apps\Shared\Http\Request\AbstractFormRequest;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Cart\Core\Product\Domain\ValueObjects\ProductQuantity;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class AddProductRequest extends AbstractFormRequest
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

    public function getProductQuantity(): ProductQuantity
    {
        $helper = $this->getHelper();
        return new ProductQuantity($helper->getRequiredInt('quantity'));
    }
}
