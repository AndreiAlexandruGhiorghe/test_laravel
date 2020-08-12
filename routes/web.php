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

Route::match(['get', 'post'], '/index', 'IndexController@show')->name('index');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@show')->name('cart.show');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
