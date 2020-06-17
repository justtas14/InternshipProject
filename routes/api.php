<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('general-info', 'ProductsController@generalInfo');

Route::get('product-info/{dish}', 'ProductsController@productInfo');

Route::get('products-filter/{page}', 'ProductsController@productsFilter');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('add-product', 'ProductsController@addProduct');
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('delete-product', 'ProductsController@deleteProduct');
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('edit-product', 'ProductsController@editProduct');
});

