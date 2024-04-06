<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('exchange_products', ExchangeProductController::class);
    Route::get('user/exchange_products', [ExchangeProductController::class, 'userProducts']);
    Route::resource('brands', BrandController::class);
    Route::resource('slides', SlidesController::class);
    Route::get('/user/orders', [OrderController::class, 'userOrders']);
    Route::get('/user/order/{order}', [OrderController::class, 'userOrder']);

    Route::post('/confirmOrder/{product}', [OrderController::class, 'confirmOrder']);
    Route::post('/rejectOrder/{product}', [OrderController::class, 'rejectOrder']);
});
Route::resource('orders', OrderController::class);

Route::get('/data/categories', [CategoryController::class, 'index']);
Route::get('/data/products', [ProductController::class, 'index']);
Route::get('/data/products/{product}', [ProductController::class, 'show']);
Route::get('/data/brands', [BrandController::class, 'index']);
Route::get('/data/slides', [SlidesController::class, 'index']);
Route::get('/data/exchange_products', [ExchangeProductController::class, 'index']);
Route::get('/data/exchange_products/{exchangeProduct}', [ExchangeProductController::class, 'show']);

Route::post('/order_exchange_product/{product}', [ExchangeProductController::class, 'orderProduct']);

Route::post('/signUp', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);
