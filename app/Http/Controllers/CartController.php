<?php

namespace App\Http\Controllers;

use App\Mail\CartMail;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $myCart = $request->session()->get('myCart', []);

        if($request->isMethod('POST')) {
            $request->validate([
                'nameField' => 'required|min:5|max:255',
                'addressField' => 'required|email'
            ]);
            $productsList = Product::select('*')->whereIn('id', array_keys($myCart))->get();
            Mail::to(request('addressField'))->send(new CartMail($productsList, $myCart, [
                'nameField' => request('nameField'),
                'addressField' => request('addressField'),
                'commentsField' => request('commentsField'),
            ]));
            return redirect(route('index'));
        }

        // get the data from the table
        $productsList = Product::select('*')->whereIn('id', array_keys($myCart))->get();

        return view('cart', ['productsList' => $productsList, 'myCart' => $myCart]);
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
