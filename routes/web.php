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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/', 'Guest\ProductController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth','admin']],function(){
    Route::get('/dashboard',function (){
        return view('admin.dashboard');
    });

    Route::get('/registeredUsers','Admin\UserController@getRegisteredUsers');
    Route::get('/user-edit/{id}','Admin\UserController@editUser');
    Route::put('/user-update/{id}','Admin\UserController@updateUser');
    Route::delete('/user-delete/{id}','Admin\UserController@deleteUser');

    Route::get('/products','Admin\ProductController@index');
    Route::post('/save-product','Admin\ProductController@store');
    Route::get('/product-edit/{id}','Admin\ProductController@edit');
    Route::put('/product-update/{id}','Admin\ProductController@update');
    Route::delete('/product-delete/{id}','Admin\ProductController@delete');

    Route::get('/categories','Admin\CategoryController@index');
    Route::post('/save-category','Admin\CategoryController@store');
    Route::delete('/delete-category/{id}','Admin\CategoryController@delete');

    Route::get('/getOrders','Admin\OrderController@getOrders');
    Route::get('/order-details/{orderId}','Admin\OrderController@getDetailsForAnOrder');
    Route::post('/change-status/{orderId}','Admin\OrderController@changeStatus');
});

Route::group(['middleware' => ['auth']],function(){
    // They Are 'Get' Just For Test :)

    Route::get('/addToCart/{productId}/{amount}','User\CartController@addToCart');
    Route::get('/getProductsAtCart','User\CartController@getProductsAtCart');
    Route::get('/emptyCart','User\CartController@emptyCart');
    Route::get('/deleteProductAtCart/{productId}','User\CartController@deleteProductAtCart');
    Route::get('/changeAmount/{productId}/{newAmount}','User\CartController@changeAmount');
    Route::get('/createOrderByCart','User\CartController@createOrder');

    Route::get('/createOrder/{productId}/{quantity}','User\OrderController@createOrder');
    Route::get('/getMyOrders','User\OrderController@getOrders');
    Route::get('/getDetailsForMyOrder/{orderId}','User\OrderController@getDetailsForAnOrder');

    Route::get('/getProfile','User\UserController@getProfile');
    Route::get('/changeDetails','User\UserController@changeDetails');
    Route::get('/changePassword/{old}/{new}/{conf}','User\UserController@changePassword');
});

Route::get('/getProductsByCategory/{id}', 'Admin\ProductController@getProductsByCategory');


