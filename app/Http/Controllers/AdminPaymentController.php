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
        $sales = Sales::where('status', 'pending')->orWhere('status', 'paid')->with('additional')
            ->orderBy('status', 'asc')->get();

        return view('admin.payment.index', compact('sales'));
    }

    public function confirm($id)
    {
        $sales = Sales::find($id);

        $sales->status = 'settlement';
        $sales->save();

        return redirect('/admin/confirm-payment');
    }

    public function deleteAll()
    {
        $deleteAll = Sales::where('status', 'pending')->delete();

        if ($deleteAll == 1) {
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
    }
}
