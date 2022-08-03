<?php

namespace Apps\Api\Product;

use App\Http\Controllers\Controller;
use Apps\Api\Product\ListProducts\ListProductsAction;
use Apps\Api\Product\ListProducts\ListProductsRequest;
use Apps\Shared\Http\Response\BadRequestResponse;
use Apps\Shared\Http\Response\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Throwable;

final class ProductController extends Controller
{

    /**
     * @param ListProductsRequest $request
     * @return JsonResponse
     */
    public function list(ListProductsRequest $request): JsonResponse
    {
        try {
            /** @var ListProductsAction $action */
            $action = App::make(ListProductsAction::class);

            return SuccessResponse::fromResource($action());

        }catch(Throwable $exception){
            return BadRequestResponse::fromException($exception);
        }
    }
}
