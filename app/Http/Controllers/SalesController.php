<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Discount;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Mail\UserTransaction;
use App\Models\PaymentMethods;
use App\Mail\AdminNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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
                $product->sales()->attach($sales, ['qty' => $item->quantity]);
            }

            // \Cart::clear();
            return redirect()->route('sales.detail', ['id' => $sales->sales_no]);
        }
        else {
            return redirect('/cart');
        }
    }

    public function detail($id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        return view('checkout.detail', compact('sales', 'user'));
    }

    public function addQuestion(Request $request, $id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        $request->validate([
            'question.*' => 'nullable',
            'inputName' => 'required',
            'inputEmail' => 'required|email',
            'inputPhone' => 'required',
            'inputBirthdate' => 'required',
            'inputRelationship' => 'required',
            'inputPekerjaan' => 'required',
        ],
        [
            'inputName.required' => 'Nama lengkap belum diisi',
            'inputEmail.required' => 'Email belum diisi',
            'inputPhone.required' => 'Nomor Telepon belum diisi',
            'inputBirthdate.required' => 'Tanggal Lahir belum diisi',
            'inputRelationship.required' => 'Status Relationship belum diisi',
            'inputPekerjaan.required' => 'Status Pekerjaan belum diisi',
        ]);

        $sales->name = $request->inputName;
        $sales->email = $request->inputEmail;
        $sales->phone = $request->inputPhone;
        $sales->birthdate = Carbon::parse($request->inputBirthdate)->format('Y-m-d');;
        $sales->paymethod_id = $request->inputPayType;
        $sales->relationship = $request->inputRelationship;
        $sales->job = $request->inputPekerjaan;

        $item_id = $request->id;
        $item_question = $request->question;

        foreach ($item_id as $key => $i) {
            $product = Products::find($item_id[$key]);
            $product->sales()->updateExistingPivot($sales, ['question' => $item_question[$key]]);
        }
        $sales->save();

        return redirect()->route('sales.summary', ['id' => $sales->sales_no]);
    }

    public function summary($id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        return view('checkout.summary', compact('sales'));
    }

    public function discount(Request $request, $id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($request->inputDiscount) {
            $disc_code = strtoupper($request->inputDiscount);
            $discount = Discount::where('code', $disc_code)->first();

            if($discount && !$discount->product_id) {
                if($sales->total_price >= $discount->min_total) {
                    $nominal = $discount->nominal;

                    $sales->discount = $nominal;
                    $sales->save();

                    return redirect()->route('sales.paymentmethods', ['id' => $sales->sales_no])->with('status', 'Discount code "'.$disc_code.'" applied (- idr '.number_format($nominal).')!');
                }
                else {
                    return redirect()->back()->with('error', 'Minimum idr '.number_format($discount->min_total).' to use discount code!');
                }
            }
            elseif($discount && $discount->product_id) {
                foreach($sales->products as $product) {
                    if($product->id == $discount->product_id) {
                        if($discount->products->price >= $discount->min_total) {
                            $nominal = $discount->nominal;

                            $sales->discount = $nominal;
                            $sales->save();

                            return redirect()->route('sales.paymentmethods', ['id' => $sales->sales_no])->with('status', 'Discount code "'.$disc_code.'" applied (- idr '.number_format($nominal).')!');
                        }
                    }
                    else {
                        $discproduct = 0;
                    }
                }
                if($discproduct == 0) {
                    return redirect()->back()->with('error', 'Discount code cannot be use for this product!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Discount Code not found!');
            }
        }
        else {
            return redirect()->route('sales.paymentmethods', ['id' => $sales->sales_no]);
        }

    }

    public function paymentMethods($id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();
        $paymethods_bank = PaymentMethods::where('account_number', '!=', 'qr')->get();
        $paymethods_qr = PaymentMethods::where('account_number', '=', 'qr')->first();
        return view('checkout.payment', compact('sales', 'paymethods_bank', 'paymethods_qr'));
    }

    public function confirmPayment($id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();
        $paymentMethods = PaymentMethods::all();

        return view('checkout.confirm-payment', compact('sales', 'paymentMethods'));
    }

    public function submitPayment(Request $request, $id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();

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

        return redirect()->route('sales.success', ['id' => $sales->sales_no]);
    }

    public function success($id)
    {
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        \Cart::clear();

        return view('checkout.payment-success', compact('sales'));
    }


}
