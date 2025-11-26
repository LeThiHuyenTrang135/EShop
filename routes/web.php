<?php

use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Route;

Route::get('/', function ( ) {
    return view('front.index');
});

Route::get('shop/product/{id}', [App\Http\Controllers\Front\ShopController::class, 'show']);