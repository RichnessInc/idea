<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class Products extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'main_image'                => 'image|mimes:jpg,jpeg,png',
            'myFiles.*'                 => 'image|mimes:jpg,jpeg,png',
            'productname'               => 'required|string|max:255',
            'category_id'               => 'required|numeric',
            'desc'                      => 'required|string|max:65000',
            'wight'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
            'width'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
            'height'                    => "required|regex:/^\d*(\.\d{1,2})?$/",
            'price'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
            'receipt_days'              => 'required|numeric',
            'aval_count'                => 'required|numeric',
        ]);
        $names = [];
        if ($request->myFiles != '') {
            foreach ($request->myFiles as $image) {
                $name = md5($image . microtime()) . '_.' . $image->extension();
                $image->storeAs('/', $name, 'uploads');
                $names[] = $name;
            }
            $files = ['images' => implode(',', $names)];
        } else {
            $files = [];
        }


        if ($request->main_image != '') {
            $name = md5($request->main_image . microtime()) . '_.' . $request->main_image->extension();
            $request->main_image->storeAs('/', $name, 'uploads');
            $file = ['main_image' => $name];
        } else {
            $file = [];
        }
        Product::findOrFail($id)->update($file + $files + [
                'name'          => $request->productname,
                'category_id'   => $request->category_id,
                'desc'          => $request->desc,
                'wight'         => $request->wight,
                'width'         => $request->width,
                'height'        => $request->height,
                'price'         => $request->price,
                'tags'          => $request->tags,
                'receipt_days'  => $request->receipt_days,
                'aval_count'    => $request->aval_count
            ]);
        return redirect()->route('frontend.product.edit', ['id' => $id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
