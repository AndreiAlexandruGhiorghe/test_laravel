<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $myCart = $request->session()->get('myCart', []);
        if($request->isMethod('POST')) {
            $request->validate([
                'nameField' => 'required',
                'addressField' => 'required'
            ]);
            echo 'something';
        }

        // get the data from the table
        $productsList = Product::select('*')->whereIn('id', array_keys($myCart))->get();

        return view('cart', ['productsList' => $productsList, '']);
    }

    public function destroy(Request $request, Product $product)
    {
        // romoving the product from cart
        $myCart = $request->session()->pull('myCart');
        Arr::forget($myCart, $product->id);
        $request->session()->put('myCart', $myCart);

        return redirect(route('cart'));
    }
}
