<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $myCart = $request->session()->get('myCart', []);


        // get the data from the table
        $productsList = Product::select('*')->whereIn('id', array_keys($myCart))->get();

        return view('cart', ['productsList' => $productsList, '']);
    }
}
