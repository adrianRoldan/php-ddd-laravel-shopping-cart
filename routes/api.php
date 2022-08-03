<?php

use Apps\Api\Cart\CartController;
use Apps\Api\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cart'], function(){

    Route::get("{userId}/show",     [CartController::class, 'showCart'])       ->name('api.cart.show');
    Route::get("list",              [CartController::class, 'list'])           ->name('api.cart.list');
    Route::post("product/add",      [CartController::class, 'addProduct'])     ->name('api.cart.product.add');
    Route::delete("product/remove", [CartController::class, 'removeProduct'])  ->name('api.cart.product.remove');

});

Route::group(['prefix' => 'product'], function(){

    Route::get("list",          [ProductController::class, 'list'])       ->name('api.product.list');
});
