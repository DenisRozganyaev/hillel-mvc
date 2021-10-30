<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
//
//Route::get('test', function() {
//    LogInfoJob::dispatch('test job');
//    LogInfoJob::dispatch('test job 5')->delay(5);
//    LogInfoJob::dispatch('test job 10')->delay(10);
//    LogInfoJob::dispatch('test job 15')->delay(15);
//    LogInfoJob::dispatch('test job 20')->delay(20);
//});

Route::get('/', 'HomeController@index')->name('home');

Route::get('products', 'ProductsController@index')->name('products');
Route::get('products/{product}', 'ProductsController@show')->name('products.show');

Route::get('categories', 'CategoriesController@index')->name('categories');
Route::get('categories/{category}', 'CategoriesController@show')->name('categories.show');

Route::delete('ajax/productImage/{image_id}', 'ProductImageController@destroy')->name('ajax.products.images.delete');

// localhost/admin/products/edit
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'BoardController')->name('home'); // admin.home

    Route::name('orders')->group(function () {
        Route::get('orders', 'OrdersController@index');
        Route::get('orders/{order}/edit', 'OrdersController@edit')->name('.edit');
        Route::put('orders/{order}', 'OrdersController@update')->name('.update');
    });

    Route::name('products')->group(function () {
        Route::get('products', 'ProductsController@index');
        Route::get('products/{product}/edit', 'ProductsController@edit')->name('.edit');
        Route::put('products/{product}/update', 'ProductsController@update')->name('.update');
        Route::delete('products/{product}', 'ProductsController@destroy')->name('.delete');
        Route::get('products/new', 'ProductsController@create')->name('.create');
        Route::post('products', 'ProductsController@store')->name('.store');
    });
});

// account/orders/5
Route::namespace('Account')->prefix('account')->name('account.')->middleware(['auth'])->group(function () {
    Route::get('/', 'UserController@index')->name('main');
    Route::get('{user}/edit', 'UserController@edit')->middleware('can:update,user')->name('edit');
    Route::put('{user}', 'UserController@update')->middleware('can:update,user')->name('update');

    Route::get('wishlist', 'WishListController@index')->name('wishlist');

    Route::name('orders')->group(function() {
       Route::get('orders', 'OrdersController@index')->name('.list');
       Route::get('orders/{order}', 'OrdersController@show')->middleware('can:show,order')->name('.show');
       Route::post('orders/{order}/cancel', 'OrdersController@cancel')->name('.cancel');
    });
});

Route::middleware('auth')->group(function() {
    Route::get('cart', 'CartController@index')->name('cart');
    Route::post('cart/{product}/add', 'CartController@add')->name('cart.add');
    Route::post('cart/product/delete', 'CartController@delete')->name('cart.delete');
    Route::post('cart/{product}/count/update', 'CartController@countUpdate')->name('cart.count.update');

    Route::get('checkout', 'CheckoutController')->name('checkout');

    Route::get('wishilist/{product}/add', 'WishListController@add')->name('wishlist.add');
    Route::delete('wishilist/{product}/delete', 'WishListController@delete')->name('wishlist.delete');

    Route::post('order', 'OrdersController@store')->name('order.create');

    Route::post('rating/{product}/add', 'RatingController@add')->name('rating.add');
});

Route::namespace('Payments')->prefix('paypal')->group(function() {
   Route::post('order/create', 'PaypalPaymentController@create');
   Route::post('order/{orderId}/capture', 'PaypalPaymentController@capture');
   Route::get('order/{orderId}/thankyou', 'PaypalPaymentController@thankYou')->middleware('auth');
});

