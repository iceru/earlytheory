<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sales;
use Illuminate\Http\Request;

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

    public function orders()
    {
        $orders = Sales::where('user_id', auth()->user()->id )->get();
        return view('orders', compact('orders'));
    }

    public function order($id)
    {
        $order = Sales::where('id', $id)->firstOrFail();
        return view('order-detail', compact('order'));
    }

    public function confirmPayment($id)
    {
        $order = Sales::where('id', $id)->firstOrFail();
        return view('confirm-pay', compact('order'));
    }
}
