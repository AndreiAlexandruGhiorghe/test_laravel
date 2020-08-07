<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    public function show(Request $request)
    {
        // retrieving data from cart or an empty array in case of myCart's absence
        $myCart = $request->session()->get('myCart', []);

        // checking if the user added a product to the cart
        if ($request->isMethod('post') && $request->input('idProduct', 0)) {
            $id = $request->input('idProduct');
            $myCart[$id] = isset($myCart[$id]) ? $myCart[$id] + 1 : 1;

            // add myCart to session
            $request->session()->put('myCart', $myCart);

            return redirect()->route('index');
        }

        if (isset($myCart) && is_array($myCart) && count($myCart)) {
            // building the query for the products from cart that
            $params = [];
            $queryString = 'inventory > CASE ';
            foreach ($myCart as $idProduct => $quantity) {
                $queryString .= 'WHEN id = ? THEN ? ';
                $params[] = $idProduct;
                $params[] = $quantity;
            }
            $queryString .= ' END;';

            // get the data from the table
            $productsList = Product::select('*')
                ->whereNotIn('id', array_keys($myCart))
                ->orWhereRaw($queryString, $params)
                ->get();
        } else {
            $productsList = Product::all();
        }

        return view('index', ['productsList' => $productsList, 'myCart' => $myCart]);
    }
}
