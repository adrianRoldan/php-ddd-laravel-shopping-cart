<?php

namespace Apps\Api\Cart;

use App\Http\Controllers\Controller;
use Apps\Api\Cart\AddProduct\AddProductAction;
use Apps\Api\Cart\AddProduct\AddProductRequest;
use Apps\Api\Cart\ListCarts\ListCartsAction;
use Apps\Api\Cart\ListCarts\ListCartsRequest;
use Apps\Api\Cart\RemoveProduct\RemoveProductAction;
use Apps\Api\Cart\RemoveProduct\RemoveProductRequest;
use Apps\Api\Cart\ShowCart\ShowCartAction;
use Apps\Api\Cart\ShowCart\ShowCartRequest;
use Apps\Shared\Http\Response\BadRequestResponse;
use Apps\Shared\Http\Response\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Throwable;

final class CartController extends Controller
{

    /**
     * @param AddProductRequest $request
     * @return JsonResponse
     */
    public function addProduct(AddProductRequest $request): JsonResponse
    {
        try {
            $request->wantJson();

            $productId = $request->getProductId();
            $userId = $request->getUserId();
            $quantity = $request->getProductQuantity();

            /** @var AddProductAction $action */
            $action = App::make(AddProductAction::class);
            $action($productId, $quantity, $userId);

            return SuccessResponse::fromMessage("Product added correctly in cart!");

        }catch(Throwable $exception){
            return BadRequestResponse::fromException($exception);
        }
    }


    /**
     * @param RemoveProductRequest $request
     * @return JsonResponse
     */
    public function removeProduct(RemoveProductRequest $request): JsonResponse
    {
        try {
            $request->wantJson();

            $userId = $request->getUserId();
            $productId = $request->getProductId();

            /** @var RemoveProductAction $action */
            $action = App::make(RemoveProductAction::class);
            $action($productId, $userId);

            return SuccessResponse::fromMessage("Product removed correctly!");

        }catch(Throwable $exception){
            return BadRequestResponse::fromException($exception);
        }
    }


    public function showCart(ShowCartRequest $request): JsonResponse
    {
        try {
            $userId = $request->getUserId();

            /** @var ShowCartAction $action */
            $action = App::make(ShowCartAction::class);

            return SuccessResponse::fromResource($action($userId));

        }catch(Throwable $exception){
            return BadRequestResponse::fromException($exception);
        }
    }

    public function list(ListCartsRequest $request): JsonResponse
    {
        try {
            /** @var ListCartsAction $action */
            $action = App::make(ListCartsAction::class);

            return SuccessResponse::fromResource($action());

        }catch(Throwable $exception){
            return BadRequestResponse::fromException($exception);
        }
    }
}
