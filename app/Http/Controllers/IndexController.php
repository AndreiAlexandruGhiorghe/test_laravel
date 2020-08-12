<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

        if (isset($myCart) && is_array($myCart) && count($myCart)) {
            $productsList = Product::productsOutsideCart($myCart)->get();
        } else {
            $productsList = Product::all();
        }

        return view('index', ['productsList' => $productsList, 'myCart' => $myCart]);
    }

    public function update(Request $request, Product $product)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

        $myCart[$product->id] = isset($myCart[$product->id]) ? $myCart[$product->id] + 1 : 1;

        // add myCart to session
        $request->session()->put('myCart', $myCart);

        return redirect()->route('index.index');
    }
}
