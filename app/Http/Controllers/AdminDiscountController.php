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
        $products = Products::where('category', 'service')->get();
    
        return view('admin.discount.index', compact('discount', 'products'));
    }

    public function store(Request $request)
    {
        $discount = new Discount;

        $request->validate([
            'inputCode' => 'required',
            'inputNominal' => 'required|integer',
            'inputMin' => 'required|integer',
            'quotaRedeem' => 'required|integer'
        ]);

        if($request->products == "0") {
            $request->products = NULL;
        }

        if($request->bulk && $request->bulk < 300) {
            for($x = 1; $x <= $request->bulk; $x++) {
                $discount = new Discount;
                $discount->code = strtoupper($request->inputCode).str_pad($x, 3, '0', STR_PAD_LEFT);
                $discount->nominal = $request->inputNominal;
                $discount->min_total = $request->inputMin;
                $discount->quota_redeem = $request->quotaRedeem;

                $discount->save();
                if($request->products[0] !== '0') {
                    foreach($request->products as $discountProduct) {
                        $product = Products::where('id', $discountProduct)->first();
                        $products[$product->id] = ['discount_id' => $discount->id];
                    }

                    $discount->products()->attach($products);
                }

            }
        } else {
            $discount->code = strtoupper($request->inputCode);
            $discount->nominal = $request->inputNominal;
            $discount->min_total = $request->inputMin;
            $discount->quota_redeem = $request->quotaRedeem;
    
            $discount->save();
            if($request->products[0] !== '0') {
                foreach($request->products as $discountProduct) {
                    $product = Products::where('id', $discountProduct)->first();
        
                    $products[$product->id] = ['discount_id' => $discount->id];
                }
        
                $discount->products()->attach($products);
            }

    
        }


        return redirect('/admin/discount');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $productIds = array();
        if($discount->products->count() > 0) {
            foreach($discount->products as $product) {
                array_push($productIds, $product->id);
            } 
        }
        $products = Products::where('category', 'service')->get();

        return view('admin.discount.edit', compact('discount', 'products', 'productIds'));
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
