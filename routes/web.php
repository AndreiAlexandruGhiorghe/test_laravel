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

Route::put('/index/{product}', 'IndexController@update')->name('index.update');
Route::get('/index', 'IndexController@index')->name('index.index');

Route::get('/product', 'ProductController@index')->name('product.index');
Route::get('/product/{product}/edit', 'ProductController@edit')->name('product.edit');
Route::delete('/product/{product}', 'ProductController@destroy')->name('product.destroy');
Route::put('/product/{product}', 'ProductController@update')->name('product.update');
Route::post('/product', 'ProductController@store')->name('product.store');
Route::get('/product/add', 'ProductController@add')->name('product.add');

Route::get('/login', 'LoginController@show')->name('login.show');
Route::post('/login', 'LoginController@store')->name('login.store');
Route::delete('/login/signout', 'LoginController@destroy')->name('login.destroy');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');

Route::get('/order', 'OrderController@index')->name('order.index');
Route::get('/order/{order}', 'OrderController@show')->name('order.show');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/spa', 'SpaController@index')->name('spa.index');

Route::middleware(['login'])->group(function () {
    Route::post('/product/{product}/option', 'OptionController@store')->name('option.store');
});
