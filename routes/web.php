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

    Route::get('/registeredUsers','User\UserController@getRegisteredUsers');
    Route::get('/user-edit/{id}','User\UserController@editUser');
    Route::put('/user-update/{id}','User\UserController@updateUser');
    Route::delete('/user-delete/{id}','User\UserController@deleteUser');

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
    // Cart Routes
    Route::get('/getProductsAtCart','User\CartController@getProductsAtCart'); // Get Cart Page
    Route::post('/emptyCart','User\CartController@emptyCart');
    Route::delete('/deleteProductAtCart/{productId}','User\CartController@deleteProductAtCart');
    Route::post('/changeAmount/{productId}','User\CartController@changeAmount');
    Route::get('/checkout','User\CartController@checkout');
    Route::post('/createOrderByCart','User\CartController@createOrder'); // Should Be After Checkout Page

    // Should Be in Single Product Page To Add a Product To Cart
    Route::get('/addToCart/{productId}/{amount}','User\CartController@addToCart');

    // Create a Order For Single Product, We are not using it
    Route::get('/createOrder/{productId}/{quantity}','User\OrderController@createOrder');

    // Get Orders And Details For An Order
    Route::get('/getMyOrders','User\OrderController@getOrders');
    Route::get('/getDetailsForMyOrder/{orderId}','User\OrderController@getDetailsForAnOrder');


    // They Are Used For User Profile To Show User Profile,To Change Details and To Change Password
    Route::get('/getProfile','User\UserController@getProfile')->name('profile');
    Route::post('/changeDetails','User\UserController@changeDetails');
    Route::post('/changePassword','User\UserController@changePassword');
});

Route::get('/getProductsByCategory/{id}', 'Admin\ProductController@getProductsByCategory');


// Support Mail Services
Route::get('/support',function (){
    return view('support.support');
});

Route::post('/sendSupportRequest','Guest\SupportController@sendRequest');
