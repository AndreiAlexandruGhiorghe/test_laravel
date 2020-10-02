<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\OptionContent;
use App\Models\Product;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'optionName' => 'required'
        ]);

        if ($request->expectsJson()) {
            $option = Option::where([
                ['product_id', $id],
                ['name', $request->get('optionName')]
            ])->get();
            if (count($option) == 0) {
                // add the option of the product
                $newOption = new Option;
                $newOption->name = $request->get('optionName');
                $newOption->product_id = $id;
                $newOption->save();
                return response()->json(['message' => 'The product was added']);
            } else {
                return response()->json(['message' => 'Option allready exists'], 400);
            }
        }
    }
}
