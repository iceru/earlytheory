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
            'birthdate' => 'required'
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
            'phone' => $request->phone
        ])->save();

        return redirect()->route('user.account-edit')->with('success', 'Data berhasil terupdate!');
    }

    public function orders()
    {
        $orders = Sales::where('user_id', auth()->user()->id )->orderBy('created_at', 'desc')->get();
        return view('orders', compact('orders'));
    }

    public function confirmPayment($id)
    {
        $paymentMethods = PaymentMethods::all();
        $order = Sales::where('sales_no', $id)->firstOrFail();
        return view('confirm-payment', compact('order', 'paymentMethods'));
    }

    public function confirmSubmit(Request $request)
    {
        $request->validate([
            'inputPayType' => 'required',
            'inputPayment' => 'max:5000'
        ],
        [
            'inputPayType.required' => 'Tipe Pembayaran belum diisi',
            // 'inputPayment.required' => 'Gambar bukti pembayaran belum diupload',
            'inputPayment.max' => 'Gambar yang diupload terlalu besar. Maksimal ukuran gambar 5MB'
        ]);

        if ($request->hasFile('inputPayment')) {
            $extension = $request->file('inputPayment')->getClientOriginalExtension();
            $filename = $sales->sales_no.'_'.time().'.'.$extension;
            $path = $request->inputPayment->storeAs('public/payment-proof', $filename);
            $sales->payment = $filename;
        }

        $sales->paymethod_id = $request->inputPayType;
        $sales->save();

        Mail::send(new UserTransaction($sales));
        Mail::send(new AdminNotification($sales));

        return redirect()->route('user.confirm-payment')->with('success', 'Pembayaran berhasil. Kami akan konfirmasi orderanmu lewat Whatsapp!');
    }
}
