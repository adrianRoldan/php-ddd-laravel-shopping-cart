<?php

namespace Apps\Api\Cart;

use App\Http\Controllers\Controller;
use Apps\Api\Cart\AddProduct\AddProductAction;
use Apps\Api\Cart\AddProduct\AddProductRequest;
use Cart\Core\Product\Domain\ValueObjects\ProductId;
use Illuminate\Support\Facades\App;

final class CartController extends Controller
{

    public function addProduct(AddProductRequest $request)
    {
        $productId = ProductId::random();

        /** @var AddProductAction $action */
        $action = App::make(AddProductAction::class);
        return $action($productId, 4);
    }
}
