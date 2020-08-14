<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titleField' => 'required',
            'descriptionField' => 'required',
            'priceField' => 'required',
            'inventoryField' => 'required',
            'fileField' => 'required',
            'imageNameField' => 'required',
        ]);
        $timestamp = now()->timestamp;
        $fileName = $timestamp . $request->file('fileField')->getClientOriginalName();

        $request->file('fileField')->storeAs(
            '/public/images',
            $fileName
        );
        dd(1);
        $product = new Product;
        $product->title = $request->get('titleField');
        $product->description = $request->get('descriptionField');
        $product->price = $request->get('priceField');
        $product->inventory = $request->get('inventoryField');
        $product->image_path = $fileName;
        $product->save();
        dd(1);
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.edit', ['id' => $id, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titleField' => 'required',
            'descriptionField' => 'required',
            'priceField' => 'required',
            'inventoryField' => 'required',
        ]);

        $product = Product::find($id);
        // checking if the image is different
        if (
            $request->hasFile('fileField')
            && $product->image_path != $request->file('fileField')->getClientOriginalName()
        ) {
            $timestamp = now()->timestamp;
            $fileName = $timestamp . $request->file('fileField')->getClientOriginalName();

            $request->file('fileField')->storeAs(
                '/public/images',
                $fileName
            );

            $product->image_path = $fileName;
        }
        $product->title = $request->get('titleField');
        $product->description = $request->get('descriptionField');
        $product->price = $request->get('priceField');
        $product->inventory = $request->get('inventoryField');
        $product->save();

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::find($id);
        if ($product) {
            if (file_exists('/public/storage/images/' . $product->image_path)) {
                if (!unlink('/public/storage/images/' . $product->image_path)) {
                    return redirect()->route('product.index');
                }
            }
            $product->delete();
        }

        return redirect()->route('product.index');
    }
}
