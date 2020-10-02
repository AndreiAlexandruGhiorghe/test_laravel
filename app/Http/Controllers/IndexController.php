<?php

namespace App\Http\Controllers;

use App\Models\Option;
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
            $productsList = Product::with(['options','options.contents'])->productsOutsideCart($myCart)->get();
        } else {
            $productsList = Product::with(['options','options.contents'])->get();
        }

        // handle the ajax request
        if ($request->expectsJson()) {
            return response()->json([
                'data' => [
                    'products' => $productsList,
                    'myCart' => $myCart
                ]
            ]);
        }

        return view('index', ['productsList' => $productsList, 'myCart' => $myCart]);
    }

    public function update(Request $request, Product $product)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

            if (!isset($myCart[strval($product->id)])) {
                $myCart[$product->id] = [];
            }
            $myCart[$product->id] += $request;//json_decode($request,true);
        return response()->json($request, 404);
        // add myCart to session
        $request->session()->put('myCart', $myCart);

        // handle the ajax request
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Added to cart'
            ]);
        }

        return redirect()->route('index.index');
    }
}
