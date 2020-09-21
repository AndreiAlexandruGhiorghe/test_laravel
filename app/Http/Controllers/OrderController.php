<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
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

        return view('order.index', ['priceOfOrder' => $priceOfOrder]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.show', ['order' =>$order]);
    }
}
