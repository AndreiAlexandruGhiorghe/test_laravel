<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

        return view('index', ['productsList' => $productsList, 'myCart' => $myCart]);
    }

    public function update(Request $request, $id)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

        $myCart[$id] = Arr::get($myCart, strval($id), 0) + 1;

        // add myCart to session
        $request->session()->put('myCart', $myCart);

        return redirect()->route('index.index');
    }
}
