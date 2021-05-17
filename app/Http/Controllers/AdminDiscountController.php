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
            'inputMin' => 'required|integer',
            'inputProduct' => 'integer'
        ]);

        if($request->inputProduct == 0) {
            $request->inputProduct = NULL;
        }

        $discount->code = strtoupper($request->inputCode);
        $discount->nominal = $request->inputNominal;
        $discount->min_total = $request->inputMin;
        $discount->product_id = $request->inputProduct;

        $discount->save();

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

        if($request->inputProduct == 0) {
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
