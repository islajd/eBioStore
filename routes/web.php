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

//www.EBioStore.com/search

Route::get('/', 'ProductController@listProducts')->name("Home");
Route::get('/category/{id}', 'ProductController@getProductsByCategory')->name("Category");
Route::get('/product/{id}', 'ProductController@getProduct')->name("Product");
Route::get('/search', 'ProductController@searchProduct')->name("Search");

Auth::routes();

Route::get('/home', 'ProductController@listProducts')->name('home');

Route::group(['middleware' => ['auth','admin']],function(){
    Route::get('/users','UserController@getUsers')->name('Users');
    Route::put('/user/{id}/changeRole','UserController@changeRole')->name('updateUser');
    Route::delete('/user/{id}/delete','UserController@deleteUser')->name('deleteUser');

    Route::get('/products','ProductController@getProducts')->name('Products');
    Route::post('/product/save','ProductController@saveProduct')->name('saveProduct');
    Route::get('/product/{id}/edit','ProductController@editProduct')->name('editProduct');
    Route::put('/product/{id}/update','ProductController@updateProduct')->name('updateProduct');
    Route::put('/product/{id}/delete','ProductController@deleteProduct')->name('deleteProduct');

    Route::get('/categories','CategoryController@getCategories')->name('Categories');
    Route::post('/category/save','CategoryController@saveCategory')->name('saveCategory');
    Route::delete('/category/{id}/delete','CategoryController@deleteCategory')->name('deleteCategory');

    Route::get('/orders','OrderController@getOrders')->name('Orders');
    Route::get('/order/{orderId}/details','OrderController@getDetailsForAnOrder')->name('orderDetails');
    Route::post('/order/{orderId}/changeStatus','OrderController@changeStatus')->name('changeOrderStatus');
});

Route::group(['middleware' => ['auth']],function(){
    // Cart Routes
    Route::get('/cart','CartController@getProductsAtCart')->name('Cart');
    Route::post('/cart/empty','CartController@emptyCart')->name('emptyCart');
    Route::delete('/cart/delete/{productId}/product','CartController@deleteProductAtCart')->name('deleteProductAtCart');
    Route::post('/cart/{productId}/changeAmount','CartController@changeAmount')->name('changeAmountCart');
    Route::get('/checkout','CartController@checkout')->name('Checkout');

    // Should Be in Single Product Page To Add a Product To Cart
    Route::post('/cart/addToCart/{productId}','CartController@addToCart')->name('addToCart');

    // Get Orders Details For An Order
    Route::get('/myOrder/{orderId}/details','OrderController@getDetailsForAnUserOrder')->name("MyOrder");

    // They Are Used For User Profile To Show User Profile,To Change Details and To Change Password
    Route::get('/profile','UserController@getProfile')->name('Profile');
    Route::post('/user/edit','UserController@changeDetails')->name('editUser');
    Route::post('/user/changePassword','UserController@changePassword')->name('changePassword');

    //PayPal Payment
    Route::post('paypal','PaymentController@payWithPayPal')->name('PayPal');
    Route::get('status','PaymentController@getPaymentStatus')->name('Status');
});




// Support Mail Services
Route::get('/support',function (){
    return view('support.support');
})->name("Support");

Route::post('/support/sendRequest','SupportController@sendRequest')->name('sendSupportRequest');
