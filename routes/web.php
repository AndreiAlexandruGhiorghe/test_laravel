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

// index urls
Route::put('/index/{product}', 'IndexController@update')->name('index.update');
Route::get('/index', 'IndexController@index')->name('index.index');



Route::middleware(['auth'])->group(function () {
    // product urls
    Route::get('/product', 'ProductController@index')->name('product.index');
    Route::get('/product/{product}/edit', 'ProductController@edit')->name('product.edit');
    Route::get('/product/add', 'ProductController@add')->name('product.add');
    Route::delete('/product/{product}', 'ProductController@destroy')->name('product.destroy');
    Route::put('/product/{product}', 'ProductController@update')->name('product.update');
    Route::post('/product', 'ProductController@store')->name('product.store');

    // order urls
    Route::get('/order', 'OrderController@index')->name('order.index');
    Route::get('/order/{order}', 'OrderController@show')->name('order.show');

    // comment urls
    Route::get('/comment', 'CommentController@index')->name('comment.index');
    Route::delete('/comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
    Route::put('/comment/{comment}', 'CommentController@update')->name('comment.update');
});

// cart urls
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');

// comment urls
Route::post('/comment', 'CommentController@store')->name('comment.store');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['register' => false]);
