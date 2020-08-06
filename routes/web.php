<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::get('/testDB', function() {
    $products = App\Product::all();
    $orders = App\Order::find(1);

    $returnValue = [
        $products[1]->orders()->select('order_products.id')->get(),
        $products[0]->orders(),
        $orders,
        \App\OrderProduct::class
    ];
    return $returnValue;
});
