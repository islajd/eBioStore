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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth','admin']],function(){
    Route::get('/users','UserController@getUsers');
    Route::put('/user/{id}/changeRole','UserController@changeRole');
    Route::delete('/user/{id}/delete','UserController@deleteUser');

    Route::get('/products','ProductController@getProducts');
    Route::post('/product/save','ProductController@saveProduct');
    Route::get('/product/{id}/edit','ProductController@editProduct');
    Route::put('/product/{id}/update','ProductController@updateProduct');
    Route::delete('/product/{id}/delete','ProductController@deleteProduct');

    Route::get('/categories','CategoryController@getCategories');
    Route::post('/category/save','CategoryController@saveCategory');
    Route::delete('/category/{id}/delete','CategoryController@deleteCategory');

    Route::get('/orders','OrderController@getOrders');
    Route::get('/order/{orderId}/details','OrderController@getDetailsForAnOrder');
    Route::post('/order/{orderId}/changeStatus','OrderController@changeStatus');
});

Route::group(['middleware' => ['auth']],function(){
    // Cart Routes
    Route::get('/cart','CartController@getProductsAtCart'); // Get Cart Page
    Route::post('/cart/empty','CartController@emptyCart');
    Route::delete('/cart/delete/{productId}/product','CartController@deleteProductAtCart');
    Route::post('/cart/{productId}/changeAmount','CartController@changeAmount');
    Route::get('/checkout','CartController@checkout');
    Route::post('/order/create','CartController@createOrder'); // Should Be After Checkout Page

    // Should Be in Single Product Page To Add a Product To Cart
    Route::get('/cart/addToCart/{productId}/{amount}','CartController@addToCart');

    // Get Orders Details For An Order
    Route::get('/myOrder/{orderId}/details','OrderController@getDetailsForAnUserOrder');

    // They Are Used For User Profile To Show User Profile,To Change Details and To Change Password
    Route::get('/profile','UserController@getProfile')->name('profile');
    Route::post('/user/edit','UserController@changeDetails');
    Route::post('/user/changePassword','UserController@changePassword');
});

Route::get('/products/{id}/category', 'ProductController@getProductsByCategory');


// Support Mail Services
Route::get('/support',function (){
    return view('support.support');
});

Route::post('/support/sendRequest','SupportController@sendRequest');
