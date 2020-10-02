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
            'optionTitle' => 'required',
            'category1' => 'required',
            'category2' => 'required',
            'category3' => 'required',
        ]);



        if ($request->expectsJson()) {
            $option = Option::where('title', $request->get('optionTitle'))->get();
            if (count($option) == 0) {
                // add the option of the product
                $newOption = new Option;
                $newOption->title = $request->get('optionTitle');
                $newOption->product_id = $id;
                $newOption->save();
                $newOptionCategory = new OptionContent;
                $newOptionCategory->option_id = $newOption->id;
                $newOptionCategory->content = $request->get('category1');
                $newOptionCategory->save();
                $newOptionCategory = new OptionContent;
                $newOptionCategory->option_id = $newOption->id;
                $newOptionCategory->content = $request->get('category2');
                $newOptionCategory->save();
                $newOptionCategory = new OptionContent;
                $newOptionCategory->option_id = $newOption->id;
                $newOptionCategory->content = $request->get('category3');
                $newOptionCategory->save();

                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'Option allready exists'], 409);
            }
        }
    }
}
