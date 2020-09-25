<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orders = Order::all();
        $priceOfOrder = [];
        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach($order->products as $product) {
                $totalPrice += $product->pivot->quantity * $product->price;
            }
            $priceOfOrder[$order->id] = $totalPrice;
        }

        if ($request->expectsJson()) {
            return response()->json($priceOfOrder);
        }

        return view('order.index', ['priceOfOrder' => $priceOfOrder]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $order = Order::with('products')->find($id);

        if ($request->expectsJson()) {
            return response()->json(['order' => $order]);
        }

        return view('order.show', ['order' =>$order]);
    }
}
