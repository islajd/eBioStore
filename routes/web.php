<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;

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

Route::get('/', 'ProductController@listProducts')->name("Home");
Route::get('/category/{id}', 'ProductController@getProductsByCategory')->name("Category");
Route::get('/product/{id}', 'ProductController@getProduct');
Route::get('/search', 'ProductController@searchProduct')->name("Search");

Auth::routes();

Route::get('/home', 'ProductController@listProducts')->name('home');

Route::group(['middleware' => ['auth','admin']],function(){
    Route::get('/users','UserController@getUsers');
    Route::put('/user/{id}/changeRole','UserController@changeRole');
    Route::delete('/user/{id}/delete','UserController@deleteUser');

    Route::get('/products','ProductController@getProducts');
    Route::post('/product/save','ProductController@saveProduct');
    Route::get('/product/{id}/edit','ProductController@editProduct');
    Route::put('/product/{id}/update','ProductController@updateProduct');
    Route::put('/product/{id}/delete','ProductController@deleteProduct');

    Route::get('/categories','CategoryController@getCategories');
    Route::post('/category/save','CategoryController@saveCategory');
    Route::delete('/category/{id}/delete','CategoryController@deleteCategory');

    Route::get('/orders','OrderController@getOrders');
    Route::get('/order/{orderId}/details','OrderController@getDetailsForAnOrder');
    Route::post('/order/{orderId}/changeStatus','OrderController@changeStatus');
});

Route::group(['middleware' => ['auth']],function(){
    // Cart Routes
    Route::get('/cart','CartController@getProductsAtCart')->name('Cart'); // Get Cart Page
    Route::post('/cart/empty','CartController@emptyCart');
    Route::delete('/cart/delete/{productId}/product','CartController@deleteProductAtCart');
    Route::post('/cart/{productId}/changeAmount','CartController@changeAmount');
    Route::get('/checkout','CartController@checkout')->name('checkout');

    // Should Be in Single Product Page To Add a Product To Cart
    Route::post('/cart/addToCart/{productId}','CartController@addToCart');

    // Get Orders Details For An Order
    Route::get('/myOrder/{orderId}/details','OrderController@getDetailsForAnUserOrder');

    // They Are Used For User Profile To Show User Profile,To Change Details and To Change Password
    Route::get('/profile','UserController@getProfile')->name('profile');
    Route::post('/user/edit','UserController@changeDetails');
    Route::post('/user/changePassword','UserController@changePassword');

    //PayPal Payment
    Route::post('paypal','PaymentController@payWithPayPal');
    Route::get('status','PaymentController@getPaymentStatus');
});




// Support Mail Services
Route::get('/support',function (){
    return view('support.support');
})->name("Support");

Route::post('/support/sendRequest','SupportController@sendRequest');
