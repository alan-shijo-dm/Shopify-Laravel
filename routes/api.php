<?php

use App\Http\Controllers\ShopifyController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'controller' => ShopifyController::class,
    'prefix' => 'products'
], function(){
    Route::get('/', 'index');
    Route::get('/{product_id}', 'view');
    Route::post('/', 'create');
    Route::put('/{product_id}', 'update');
    Route::delete('/{product_id}', 'destroy');
    Route::post('/get/graphql/curl','graphQLcurlProducts');
});

Route::get('/customers/{customer_id}', [ShopifyController::class, 'curl']);
Route::post('/graphql/guzzle', [ShopifyController::class, 'graphQLGuzzle']);
Route::post('/graphql/curl', [ShopifyController::class, 'graphQLCurl']);

