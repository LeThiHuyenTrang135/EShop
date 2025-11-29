<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShopController;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'] );



Route::prefix('shop')->group(function (){
    Route::get('product/{id}', [App\Http\Controllers\Front\ShopController::class, 'show']);
    // Route::post('shop/product/{id}', [App\Http\Controllers\Front\ShopController::class, 'postComment']);

    Route::post('product/{id}/comment', [ShopController::class, 'postComment'])
        ->name('product.comment');

    Route::post('product/{id}', [ShopController::class, 'postComment'])->name('shop.postComment');

    Route::get('', [App\Http\Controllers\Front\ShopController::class, 'index']);

    Route::get('category/{categoryName}', [App\Http\Controllers\Front\ShopController::class, 'category']);


});

Route::prefix('cart')->group(function (){
    Route::get('add', [App\Http\Controllers\Front\CartController::class, 'add']);
    Route::get('/', [App\Http\Controllers\Front\CartController::class, 'index']);
    Route::get('delete', [App\Http\Controllers\Front\CartController::class, 'delete']);

});





