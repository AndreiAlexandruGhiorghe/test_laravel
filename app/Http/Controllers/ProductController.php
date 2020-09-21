<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;

class ProductController extends Controller
{
    private function storeOrUpdate(Request $request, $product = null)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'inventory' => 'required',
        ]);

        if (!$product) {
            $request->validate(['file' => 'required']);
            $newProduct = new Product;
        } else {
            $newProduct = Product::find($product);
        }

        if ($request->file('file')) {
            $fileName = now()->timestamp . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('/public/images', $fileName);
        } else {
            $fileName = $newProduct->image_path;
        }

        $newProduct->fill($request->only(['title', 'description', 'price', 'inventory']) + ['image_path' => $fileName]);

        $newProduct->save();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index', ['products' => Product::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->storeOrUpdate($request);

        return redirect()->route('product.index');
    }

    public function add()
    {
        return view('product.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $productDetails = Product::find($product);

        return view('product.edit', ['id' => $product, 'product' => $productDetails]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product)
    {
        $this->storeOrUpdate($request, $product);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $productDetails = Product::find($product);
        if ($productDetails) {
            if (file_exists('/public/storage/images/' . $productDetails->image_path)) {
                if (!unlink('/public/storage/images/' . $productDetails->image_path)) {
                    return redirect()->route('product.index');
                }
            }
            $productDetails->delete();
        }

        return redirect()->route('product.index');
    }
}
