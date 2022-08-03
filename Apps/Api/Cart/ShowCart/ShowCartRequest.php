<?php

namespace Apps\Api\Cart\ShowCart;

use Apps\Shared\Http\Request\AbstractFormRequest;
use Cart\Core\User\Domain\ValueObjects\UserId;

final class ShowCartRequest extends AbstractFormRequest
{

    public function getUserId(): UserId
    {
        $helper = $this->getHelper();
        return UserId::create($helper->routeString('userId'));
    }
}
