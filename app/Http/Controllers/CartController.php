<?php

namespace App\Http\Controllers;

use App\Mail\CartMail;
use App\Order;
use App\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Prophecy\Doubler\Generator\Node\ArgumentNode;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $myCart = $request->session()->get('myCart', []);

        // get the data from the table
        $productsList = Product::select('*')->whereIn('id', array_keys($myCart))->get();

        return view('cart', ['productsList' => $productsList, 'myCart' => $myCart]);
    }

    public function show(Request $request)
    {
        $request->validate([
            'nameField' => 'required|min:5|max:255',
            'addressField' => 'required|email'
        ]);
        $myCart = $request->session()->get('myCart', []);

        $order = new Order;
        $order->name = $request->get('nameField');
        $order->address = $request->get('addressField');
        $order->comments = $request->get('commentsField');
        $order->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $order->save();

        foreach ($myCart as $productId => $productQuantity) {
            $orderProduct = new OrderProduct;
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $productId;
            $orderProduct->quantity = $productQuantity;
            $orderProduct->save();
        }

        $productsList = Product::select('*')->whereIn('id', array_keys($myCart))->get();

        Mail::to(request('addressField'))->send(new CartMail($productsList, $myCart, [
            'nameField' => request('nameField'),
            'addressField' => request('addressField'),
            'commentsField' => request('commentsField'),
        ]));

        $products = Product::whereIn('id', array_keys($myCart))->get();
        foreach ($products as $product) {
            $product->inventory -= $myCart[$product->id];
            $product->save();
        }

        $request->session()->forget('myCart');

        return redirect(route('index'));
    }

    public function destroy(Request $request, Product $product)
    {
        // romoving the product from cart
        $myCart = $request->session()->pull('myCart');
        Arr::forget($myCart, $product->id);
        $request->session()->put('myCart', $myCart);

        return redirect(route('cart.index'));
    }
}
