<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Products;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    public function index()
    {
        $discount = Discount::all();
        $products = Products::all();
    
        return view('admin.discount.index', compact('discount', 'products'));
    }

    public function store(Request $request)
    {
        $discount = new Discount;

        $request->validate([
            'inputCode' => 'required',
            'inputNominal' => 'required|integer',
            'inputMin' => 'required|integer'
        ]);

        if($request->inputProduct == "0") {
            $request->inputProduct = NULL;
        }

        $discount->code = strtoupper($request->inputCode);
        $discount->nominal = $request->inputNominal;
        $discount->min_total = $request->inputMin;

        $savediscount = $discount->save();

        $request->inputProduct = substr($request->inputProduct, 0, -1);
        $productsArray = explode(', ', strtolower($request->inputProduct));
        $products = array();

        // dd($productsArray);

        foreach($productsArray as $discountProduct) {
            $product = Products::where('title', $discountProduct)->first();

            $products[$product->id] = ['discount_id' => $discount->id];
        }

        $discount->products()->attach($products);

        return redirect('/admin/discount');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $products = Products::all();

        return view('admin.discount.edit', compact('discount', 'products'));
    }

    public function update(Request $request)
    {
        $discount = Discount::find($request->id);

        $request->validate([
            'updateCode' => 'required',
            'updateNominal' => 'required|integer',
            'updateMin' => 'required|integer',
            'updateProduct' => 'integer'
        ]);

        if($request->updateProduct == "0") {
            $request->updateProduct = NULL;
        }

        $discount->code = strtoupper($request->updateCode);
        $discount->nominal = $request->updateNominal;
        $discount->min_total = $request->updateMin;
        $discount->product_id = $request->updateProduct;

        $discount->save();

        return redirect('/admin/discount');
    }

    public function destroy($id)
    {
        Discount::find($id)->delete();
        return redirect('/admin/discount');
    }
}
