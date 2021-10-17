<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('api')->group(function() {

    Route::post('login', 'AuthController@login')->name('login');

    Route::namespace('v1')->prefix('v1')->group(function() {
        Route::get('products/{product}', 'ProductsController@show')->name('products.show');


        Route::group(['middleware' => ['auth:sanctum']], function() {
            Route::get('products', 'ProductsController@index')->name('products');

            Route::group(['middleware' => ['admin']], function() {
                Route::post('categories', 'CategoriesController@create')->name('categories.create');
            });

        });
    });

});
