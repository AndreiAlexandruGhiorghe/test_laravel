<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function show(Request $request)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

        // checking if the user added a product to the cart
        if ($request->isMethod('post') && $request->input('idProduct', 0)) {
            $id = $request->input('idProduct');
            $myCart[$id] = isset($myCart[$id]) ? $myCart[$id] + 1 : 1;

            // add myCart to session
            $request->session()->put('myCart', $myCart);

            return redirect()->route('index');
        }

        if (isset($myCart) && is_array($myCart) && count($myCart)) {
            $productsList = Product::productsOutsideCart($myCart)->get();
        } else {
            $productsList = Product::all();
        }

        return view('index', ['productsList' => $productsList, 'myCart' => $myCart]);
    }
}
