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
        $delete = Sales::find($id)->delete();
        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Sales deleted successfully";
        } else {
            $success = false;
            $message = "Sales not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
        // return redirect('/admin/sales');
    }
}
