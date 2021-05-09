<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    public function index()
    {
        $discount = Discount::all();
    
        return view('admin.discount.index', compact('discount'));
    }

    public function store(Request $request)
    {
        $discount = new Discount;

        $request->validate([
            'inputCode' => 'required',
            'inputNominal' => 'required|integer',
            'inputMin' => 'required|integer',
        ]);

        $discount->code = strtoupper($request->inputCode);
        $discount->nominal = $request->inputNominal;
        $discount->min_total = $request->inputMin;

        $discount->save();

        return redirect('/admin/discount');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);

        return view('admin.discount.edit', compact('discount'));
    }

    public function update(Request $request)
    {
        $discount = Discount::find($request->id);

        $request->validate([
            'updateCode' => 'required',
            'updateNominal' => 'required|integer',
            'updateMin' => 'required|integer'
        ]);

        $discount->code = strtoupper($request->updateCode);
        $discount->nominal = $request->updateNominal;
        $discount->min_total = $request->updateMin;

        $discount->save();

        return redirect('/admin/discount');
    }

    public function destroy($id)
    {
        Discount::find($id)->delete();
        return redirect('/admin/discount');
    }
}
