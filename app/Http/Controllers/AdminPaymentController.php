<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $sales = Sales::where('status', 'pending')->get();

        return view('admin.payment.index', compact('sales'));
    }

    public function confirm($id)
    {
        $sales = Sales::find($id);

        $sales->status = 'settlement';
        $sales->save();

        return redirect('/admin/confirm-payment');
    }
}
