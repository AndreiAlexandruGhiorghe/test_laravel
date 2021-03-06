<?php

namespace App\Http\Controllers;

use App\Mail\CartMail;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
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

    public function store(Request $request)
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

        Mail::to($request->input('addressField'))->send(new CartMail($productsList, $myCart, [
            'nameField' => $request->input('nameField'),
            'addressField' => $request->input('addressField'),
            'commentsField' => $request->input('commentsField'),
        ]));

        $products = Product::whereIn('id', array_keys($myCart))->get();
        foreach ($products as $product) {
            $product->inventory -= $myCart[$product->id];
            $product->save();
        }

        $request->session()->forget('myCart');

        return redirect(route('index.index'));
    }

    public function destroy(Request $request, $id)
    {
        // romoving the product from cart
        $myCart = $request->session()->pull('myCart');
        Arr::forget($myCart, $id);
        $request->session()->put('myCart', $myCart);

        return redirect(route('cart.index'));
    }
}
