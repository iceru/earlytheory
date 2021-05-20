<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethods::all();

        return view('admin.paymentMethods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentMethod = new PaymentMethods;

        $request->validate([
            'inputName' => 'required',
            'inputLogo' => 'required|image',
            'inputAccNum' => 'required',
            'inputAccOwn' => 'required'
        ]);

        if ($request->hasFile('inputLogo')) {
            $extension = $request->file('inputLogo')->getClientOriginalExtension();
            $filename = $request->inputName.'_'.time().'.'.$extension;
            $path = $request->inputLogo->storeAs('public/payment-logo', $filename);
        }

        $paymentMethod->name = $request->inputName;
        $paymentMethod->logo = $filename;
        $paymentMethod->account_number = $request->inputAccNum;
        $paymentMethod->account_owner = $request->inputAccOwn;

        $paymentMethod->save();

        return redirect('/admin/payment-methods');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethods::findOrFail($id);

        return view('admin.paymentMethods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $paymentMethod = PaymentMethods::find($request->id);

        $request->validate([
            'updateName' => 'required',
            'updateLogo' => 'image|nullable',
            'updateAccNum' => 'required',
            'updateAccOwn' => 'required'

        ]);

        if ($request->hasFile('updateLogo')) {
            $extension = $request->file('updateLogo')->getClientOriginalExtension();
            $filename = $request->updateName.'_'.time().'.'.$extension;
            $path = $request->updateLogo->storeAs('public/payment-logo', $filename);
            $paymentMethod->logo = $filename;
        }
        
        $paymentMethod->name = $request->updateName;
        $paymentMethod->account_number = $request->updateAccNum;
        $paymentMethod->account_owner = $request->updateAccOwn;

        $paymentMethod->save();

        return redirect('/admin/payment-methods');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethods::findOrFail($id);
        Storage::disk('public')->delete('payment-logo/'.$paymentMethod->logo);
        
        PaymentMethods::find($id)->delete();
        return redirect('/admin/payment-methods');
    }
}
