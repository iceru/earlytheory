<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Discount;
use App\Models\Products;
use App\Models\ShippingAddress;
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
            $userid = Auth::id();
            $cart = \Cart::getContent();
            // foreach ($cart as $item) {
            //     dd($item->id);
            // }

            $salesNo = time();
            $total = \Cart::getTotal();

            $sales = new Sales;
            $sales->sales_no = $salesNo;
            $sales->total_price = $total;
            $sales->user_id = $userid;
            $sales->save();

            foreach (\Cart::getContent() as $item) {
                $product = Products::find($item->id);
                $product->sales()->attach($sales, ['qty' => $item->quantity]);
                $product->stock = $product->stock-$item->quantity;
                $product->save();
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

        if($user->id == $sales->user_id) {
            return view('checkout.detail', compact('sales', 'user'));
        }

        else {
            return redirect('/');
        }

    }

    public function addQuestion(Request $request, $id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {

            $request->validate([
                'inputPhone' => 'required',
                'inputBirthdate' => 'required',
                'inputRelationship' => 'required',
                'inputPekerjaan' => 'required',
            ],
            [
                'inputPhone.required' => 'Nomor Telepon belum diisi',
                'inputBirthdate.required' => 'Tanggal Lahir belum diisi',
                'inputRelationship.required' => 'Status Relationship belum diisi',
                'inputPekerjaan.required' => 'Status Pekerjaan belum diisi',
            ]);
    
            // $sales->paymethod_id = $request->inputPayType;
            $sales->phone = $request->inputPhone;
            $sales->inputBirthdate = $request->inputBirthdate;
            $sales->relationship = $request->inputRelationship;
            $sales->job = $request->inputPekerjaan;
    
            $item_id = $request->id;
            $item_question = $request->question;
    
            foreach ($item_id as $key => $i) {
                $product = Products::find($item_id[$key]);
                $product->sales()->updateExistingPivot($sales, ['question' => $item_question[$key]]);
            }
            $sales->save();

    
            // Check product category in sales
            $is_product = 0;
            foreach ($sales->products as $item) {
                if($item->category === 'product') {
                    $is_product += 1;
                }
            }
    
            if($is_product > 0) {
                return redirect()->route('sales.shipping', ['id' => $sales->sales_no]);
            }
            elseif($is_product == 0) {
                return redirect()->route('sales.summary', ['id' => $sales->sales_no]);
            }
        }

        else {
            return redirect('/');
        }        
    }

    public function shipping($id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();
        
        if($user->id == $sales->user_id) {
            $address = ShippingAddress::where('user_id', $user->id)->get();

            foreach($address as $a) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/city?id=".$a->ship_city."&province=".$a->ship_province,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: 6647e093d8e3502f18a50d44d52e032a"
                ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                $result = json_decode($response);
                $a->province = $result->rajaongkir->results->province;
                $a->city = $result->rajaongkir->results->type." ".$result->rajaongkir->results->city_name;
                
            }
                
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 6647e093d8e3502f18a50d44d52e032a"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $prov = json_decode($response);
            $provinces = $prov->rajaongkir->results;

            return view('checkout.shipping', compact('sales', 'address', 'provinces'));
        }

        else {
            return redirect('/');
        }   
    }

    public function findCityShipping(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$request->id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 6647e093d8e3502f18a50d44d52e032a"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        $city = json_decode($response);
        $cities = $city->rajaongkir->results;

        return $cities;
    }

    public function checkShippingCost(Request $request)
    {
        $shippingAddress = ShippingAddress::where('id', $request->id)->firstOrFail();

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=153&destination=".$shippingAddress->ship_city."&weight=1000&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: 6647e093d8e3502f18a50d44d52e032a"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $cost = json_decode($response);
        $costs = $cost->rajaongkir->results[0]->costs;

        return $costs;
    }

    public function addShipping(Request $request, $id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {
            $request->validate([
                'inputAddress' => 'required',
                'inputShipping' => 'required',
            ],
            [
                'inputAddress.required' => 'Alamat belum dipilih',
                'inputShipping.required' => 'Shipping belum diisi',
            ]);
    
            $shipping = explode("-",$request->inputShipping);
    
            $sales->address_id = $request->inputAddress;
            $sales->ship_cost = $shipping[0];
            $sales->ship_method = $shipping[1];
            $sales->save();
    
            return redirect()->route('sales.summary', ['id' => $sales->sales_no]);
        }

        else {
            return redirect('/');
        }   
    }

    public function summary($id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {

            if($sales->address_id) {
                $curl = curl_init();
            
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.rajaongkir.com/starter/city?id=".$sales->shippingAddress->ship_city."&province=".$sales->shippingAddress->ship_province,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                    "key: 6647e093d8e3502f18a50d44d52e032a"
                    ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                
                curl_close($curl);
                
                $result = json_decode($response);
        
                $sales->shippingAddress->province = $result->rajaongkir->results->province;
                $sales->shippingAddress->city = $result->rajaongkir->results->type." ".$result->rajaongkir->results->city_name;
            }
            
            return view('checkout.summary', compact('sales'));
        }

        else {
            return redirect('/');
        }
    }

    public function discount(Request $request, $id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();
        
        if($user->id == $sales->user_id) {
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

        else {
            return redirect('/');
        }
    }

    public function paymentMethods($id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {
            $paymethods_bank = PaymentMethods::where('account_number', '!=', 'qr')->get();
            $paymethods_qr = PaymentMethods::where('account_number', '=', 'qr')->first();
            return view('checkout.payment', compact('sales', 'paymethods_bank', 'paymethods_qr'));
        }

        else {
            return redirect('/');
        }
    }

    public function confirmPayment($id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {
            $paymentMethods = PaymentMethods::all();
    
            return view('checkout.confirm-payment', compact('sales', 'paymentMethods'));
        }

        else {
            return redirect('/');
        }
    }

    public function submitPayment(Request $request, $id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {
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

        else {
            return redirect('/');
        }
    }

    public function success($id)
    {
        $user = Auth::user();
        $sales = Sales::where('sales_no', $id)->firstOrFail();

        if($user->id == $sales->user_id) {
            \Cart::clear();
    
            return view('checkout.payment-success', compact('sales'));
        }

        else {
            return redirect('/');
        }
    }


}
