<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['login' => false, 'confirm' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('product-info/{dish}', 'HomeController@productInfo');

