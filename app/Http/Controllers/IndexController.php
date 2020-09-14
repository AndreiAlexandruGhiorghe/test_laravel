<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Arr;

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

        // handle the ajax request
        if ($request->expectsJson()) {
            $json = $productsList->toJson();
            $arr = [];
            $arr['products'] = json_decode($json,true);
            $arr['myCart'] = $myCart;
            $json = json_encode($arr, true);
            return $json;
        }

        return view('index', ['productsList' => $productsList, 'myCart' => $myCart]);
    }

    public function update(Request $request, Product $product)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

        $myCart[$product->id] = Arr::get($myCart, strval($product->id), 0) + 1;

        // add myCart to session
        $request->session()->put('myCart', $myCart);

        // handle the ajax request
        if ($request->expectsJson()) {
            if (isset($myCart) && is_array($myCart) && count($myCart)) {
                $productsList = Product::productsOutsideCart($myCart)->get();
            } else {
                $productsList = Product::all();
            }

            $json = $productsList->toJson();
            $arr = [];
            $arr['products'] = json_decode($json,true);
            $arr['myCart'] = $myCart;
            $json = json_encode($arr, true);
            return $json;
        }

        return redirect()->route('index.index');
    }
}
