<?php

use App\Http\Controllers\Front\ShopController;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Route;

Route::get('/', function ( ) {
    return view('front.index');
});

Route::get('shop/product/{id}', [App\Http\Controllers\Front\ShopController::class, 'show']);
// Route::post('shop/product/{id}', [App\Http\Controllers\Front\ShopController::class, 'postComment']);

Route::post('/shop/product/{id}/comment', [ShopController::class, 'postComment'])
    ->name('product.comment');

Route::post('/shop/product/{id}', [ShopController::class, 'postComment'])->name('shop.postComment');
