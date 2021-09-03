<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function account()
    {
        return view('account')->with('user', auth()->user());
    }

    public function accountEdit()
    {
        return view('account-edit')->with('user', auth()->user());
    }
    
    public function accountUpdate(Request $request) {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birthdate' => 'nullable',
            // 'job' => 'nullable',
            // 'relationship' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.account-edit')
            ->withErrors($validator)
            ->withInput();
        };
        
        $update = $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
            // 'job' => $request->job,
            // 'relationship' => $request->relationship,
        ])->save();

        return redirect()->route('user.account-edit')->with('success', 'Data berhasil terupdate!');
    }

    public function orders()
    {
        $orders = Sales::where('user_id', auth()->user()->id )->get();
        return view('orders', compact('orders'));
    }

    // public function order($id)
    // {
    //     $order = Sales::where('id', $id)->firstOrFail();
    //     return view('order-detail', compact('order'));
    // }

    public function confirmPayment($id)
    {
        $paymentMethods = PaymentMethods::all();
        $order = Sales::where('sales_no', $id)->firstOrFail();
        return view('confirm-payment', compact('order', 'paymentMethods'));
    }
}
