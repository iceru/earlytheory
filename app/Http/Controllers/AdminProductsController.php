<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();

        return view('admin.products.index', compact('products'));
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
        $product = new Products;

        $request->validate([
            'inputTitle' => 'required',
            'inputPrice' => 'required|integer',
            'inputDesc' => 'required',
        ]);

        $product->title = $request->inputTitle;
        $product->price = $request->inputPrice;
        $product->description = $request->inputDesc;

        if(strlen($request->inputDesc) > 40) {
            $shortDesc = substr($request->inputDesc, 0, strpos($request->inputDesc, ' ', 40)).'...';
        }
        else {
            $shortDesc = $request->inputDesc;   
        }
        $product->description_short = $shortDesc;

        $product->save();

        return redirect('/admin/products');
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
        $product = Products::findOrFail($id);

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Products::find($request->id);

        $request->validate([
            'updateTitle' => 'required',
            'updatePrice' => 'required|integer',
            'updateDesc' => 'required',
        ]);

        $product->title = $request->updateTitle;
        $product->price = $request->updatePrice;
        $product->description = $request->updateDesc;

        if(strlen($request->updateDesc) > 40) {
            $shortDesc = substr($request->updateDesc, 0, strpos($request->updateDesc, ' ', 40)).'...';
        }
        else {
            $shortDesc = $request->updateDesc;   
        }
        $product->description_short = $shortDesc;

        $product->save();

        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::find($id)->delete();
        return redirect('/admin/products');
    }
}
