<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    private function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'inventory' => 'required',
        ]);

        if (!$id) {
            $request->validate(['file' => 'required']);
            $product = new \App\Models\Product;
        } else {
            $product = Product::find($id);
        }

        if ($request->file('file')) {
            $fileName = now()->timestamp . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('/public/images', $fileName);
        } else {
            $fileName = $product->image_path;
        }

        $product->fill($request->only(['title', 'description', 'price', 'inventory']));
        $product->fill(['image_path' => $fileName]);

        $product->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $arr['products'] = Product::all();
//        $json = json_encode($arr, true);
//        return $json;
        if (request()->expectsJson()) {
            $arr['products'] = Product::all();
            $json = json_encode($arr, true);
            return $json;
        }
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->storeOrUpdate($request);

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
        $this->storeOrUpdate($request, $id);

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

    public function add()
    {
        return view('product.edit');
    }
}
