<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Sales;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Mail\UserTransaction;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

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
            'birthdate' => 'required',
            'password' => ['nullable', 'confirmed', Password::min(8)],
            // 'currentPassword' => 'required_with:newPassword|current_password:api'
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.account-edit')
            ->withErrors($validator)
            ->withInput();
        };
        
        $update = $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate
        ])->save();

        if($request->password) {
            $update = $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
        }

        return redirect()->route('user.account-edit')->with('success', 'Data berhasil terupdate!');
    }

    public function orders()
    {
        $orders = Sales::where('user_id', auth()->user()->id )->orderBy('created_at', 'desc')->get();
        // $is_service = 0;
        // foreach ($orders->products as $item) {
        //     if($item->category === 'service') {
        //         $is_service += 1;
        //     }
        // }

        return view('orders', compact('orders'));
    }

    public function confirmPayment($id)
    {
        $paymentMethods = PaymentMethods::all();
        $order = Sales::where('sales_no', $id)->firstOrFail();
        $is_soldout = 0;
        foreach($order->products as $item) {
            $product = Products::where('id', $item->id)->where('category', 'product')->where('stock', '<=', 0)->first();
            if($product) {
                $is_soldout = 1;
            }
        }
        return view('confirm-payment', compact('order', 'paymentMethods', 'is_soldout'));
    }

    public function confirmSubmit(Request $request, $id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        $is_soldout = 0;
        foreach($sales->products as $item) {
            $product = Products::where('id', $item->id)->where('category', 'product')->where('stock', '<=', 0)->first();
            if($product) {
                $is_soldout = 1;
            }
        }

        if($is_soldout === 0) {
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
            // Mail::send(new AdminNotification($sales));
        }
        elseif($is_soldout === 1) {
            return redirect()->back()->with('soldout');
        }


        return redirect()->route('user.confirm-payment', $id)->with('success', 'Pembayaran berhasil. Kami akan konfirmasi orderanmu lewat Whatsapp!');
    }
}
