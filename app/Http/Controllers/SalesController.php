<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use App\Models\Discount;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function checkout()
    {
        if(!\Cart::isEmpty()) {
            $cart = \Cart::getContent();
            // foreach ($cart as $item) {
            //     dd($item->id);
            // }

            $salesNo = time();
            $total = \Cart::getTotal();

            $sales = new Sales;
            $sales->sales_no = $salesNo;
            $sales->total_price = $total;
            $sales->email = ' ';
            $sales->save();

            foreach (\Cart::getContent() as $item) {
                $product = Products::find($item->id);
                $product->sales()->attach($sales, ['question' => ' '], ['qty' => $item->qty]);
            }

            \Cart::clear();
            return redirect()->route('sales.detail', ['id' => $sales->id]);
        }
        else {
            return redirect('/cart');
        }
    }

    public function detail($id)
    {
        $sales = Sales::find($id);

        return view('checkout.detail', compact('sales'));
    }

    public function addQuestion(Request $request, $id)
    {
        $sales = Sales::find($id);

        $item_id = $request->id;
        $item_question = $request->question;

        foreach ($item_id as $key => $i) {
            $product = Products::find($item_id[$key]);
            $product->sales()->updateExistingPivot($sales, ['question' => $item_question[$key]]);
        }

        return redirect()->route('sales.summary', ['id' => $sales->id]);
    }

    public function summary($id)
    {
        $sales = Sales::find($id);

        return view('checkout.summary', compact('sales'));
    }

    public function discount(Request $request, $id)
    {
        $sales = Sales::find($id);

        if($request->inputDiscount) {
            $disc_code = strtoupper($request->inputDiscount);
            $discount = Discount::where('code', $disc_code)->first();

            if($discount) {
                if($sales->total_price >= $discount->min_total) {
                    $nominal = $discount->nominal;

                    $sales->discount = $nominal;
                    $sales->save();

                    return redirect()->route('sales.paymentmethods', ['id' => $sales->id])->with('status', 'Discount code "'.$disc_code.'" applied (- idr '.number_format($nominal).')!');
                }
                else {
                    return redirect()->back()->with('error', 'Minimum idr '.number_format($discount->min_total).' to use discount code!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Discount Code not found!');
            }
        }
        else {
            return redirect()->route('sales.paymentmethods', ['id' => $sales->id]);
        }

    }

    public function paymentMethods($id)
    {
        $sales = Sales::find($id);
        $paymethods_bank = PaymentMethods::where('account_number', '!=', 'qr')->get();
        $paymethods_qr = PaymentMethods::where('account_number', '=', 'qr')->first();
        return view('checkout.payment', compact('sales', 'paymethods_bank', 'paymethods_qr'));
    }

    public function confirmPayment($id)
    {
        $sales = Sales::find($id);

        return view('checkout.confirm-payment', compact('sales'));
    }

    public function submitPayment(Request $request, $id)
    {
        $sales = Sales::find($id);

        $request->validate([
            'inputEmail' => 'required|email'
        ]);

        if ($request->hasFile('inputPayment')) {
            $extension = $request->file('inputPayment')->getClientOriginalExtension();
            $filename = $sales->sales_no.'_'.time().'.'.$extension;
            $path = $request->inputPayment->storeAs('public/payment-proof', $filename);
            $sales->payment = $filename;
        }

        $sales->email = $request->inputEmail;
        $sales->status = "success";
        $sales->save();

        return redirect()->route('sales.success', ['id' => $sales->id]);
    }

    public function success($id)
    {
        $sales = Sales::find($id);
        return view('checkout.payment-success', compact('sales'));
    }


}
