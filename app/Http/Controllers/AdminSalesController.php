<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class AdminSalesController extends Controller
{
    public function index()
    {
        $sales = Sales::all();

        return view('admin.sales.index', compact('sales'));
    }

    public function detail($id)
    {
        $sales = Sales::find($id);

        return view('admin.sales.detail', compact('sales'));
    }

    public function destroy($id)
    {
        Sales::find($id)->delete();
        return redirect('/admin/sales');
    }
}
