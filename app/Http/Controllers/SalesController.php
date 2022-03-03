<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Discount;
use App\Models\Products;
use App\Models\ShippingAddress;
use App\Models\OptionValues;
use App\Models\SKUvalues;
use Illuminate\Http\Request;
use App\Mail\UserTransaction;
use App\Models\PaymentMethods;
use App\Mail\AdminNotification;
use App\Models\SKUs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SalesController extends Controller
{
    public function checkout(Request $request)
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
                // $product = Products::find($item->attributes->product_id);
                // $product->sales()->attach($sales, ['qty' => $item->quantity]);
                // // $product->stock = $product->stock-$item->quantity;
                // $product->save();
                $sku = SKUs::find($item->attributes->sku_id);
                // $product = Products::find($item->attributes->product_id);
                if($sku && $sku->stock > 0 && $sku->stock >= $item->quantity) {
                    $sku->sales()->attach($sales, ['qty' => $item->quantity]);
                    $sku->save();
                } 
                elseif($sku->stock <= 0) {
                    return back()->withErrors('Stok Produk Habis');
                }
                else {
                    return back()->withErrors('Product(s) not valid. Please contact us');
                }
                // $product->stock = $product->stock-$item->quantity;
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

        $is_product = 0;
        $is_service = 0;

        // dd($sales->skus->products->name);
        foreach ($sales->skus as $item) {
            if($item->products->category === 'product') {
                $is_product += 1;
            }

            if($item->products->category === 'service') {
                $is_service += 1;
            }
        }

        if($user->id == $sales->user_id) {
            if($is_product > 0) {
                $address = ShippingAddress::where('user_id', $user->id)->get();

                foreach($address as $a) {
                    if(Cache::has('address_'.$a->ship_city.'_'.$a->ship_province)) {
                        $response = Cache::get('address_'.$a->ship_city.'_'.$a->ship_province);
                    }
                    else {
                        $curl = curl_init();
        
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?id=".$a->ship_city."&province=".$a->ship_province,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "key: ".env('RAJAONGKIR_KEY')
                        ),
                        ));
        
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
        
                        curl_close($curl);
                        Cache::put('address_'.$a->ship_city.'_'.$a->ship_province, $response, now()->addMinutes(1440));
                    }
    
                    $result = json_decode($response);
                    
                    $a->province = $result->rajaongkir->results->province;
                    $a->city = $result->rajaongkir->results->type." ".$result->rajaongkir->results->city_name;
                    
                }

                if(Cache::has('provinces')) {
                    $response = Cache::get('provinces');
                }
                else {
                    $curl = curl_init();
        
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "key: ".env('RAJAONGKIR_KEY')
                    ),
                    ));
        
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
        
                    curl_close($curl);
                    Cache::put('provinces', $response, now()->addMinutes(1440));
                }    
    
                $prov = json_decode($response);
                $provinces = $prov->rajaongkir->results;

                $skuvalues = SKUvalues::all();
                $optionvalues = OptionValues::all();
                $values = array();
                $values_collection = collect();
                foreach($sales->skus as $key => $sku) {
                    foreach ($skuvalues as $key => $skuvalue) {
                        if($sku->id == $skuvalue->sku_id) {
                            foreach ($optionvalues as $key => $option) {
                                if($skuvalue->option_id == $option->option_id && $skuvalue->value_id == $option->id) {
                                    $value_datas = OptionValues::where('id', $skuvalue->value_id)->pluck('value_name');
                                    $value_name = $value_datas->implode('', 'value_name');
                                    array_push($values, $value_name);
                                }
                            }
                        }
                    }
                    $sku->setAttribute('variants', $values);
                    $values = array();
                }
    
                return view('checkout.detail', compact('sales', 'address', 'user', 'provinces', 'is_product', 'is_service', 'values'));
            }
            return view('checkout.detail', compact('sales', 'user', 'is_product', 'is_service'));
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
                'inputRelationship' => 'nullable',
                'inputPhone' => 'nullable',
                'inputBirthdate' => 'nullable',
                'inputPekerjaan' => 'nullable',
            ]);
    
            // $sales->paymethod_id = $request->inputPayType;
           
            if ($user->phone == '' || $user->birthdate == '') {
                if($user->phone == '') {
                    $user->phone = $request->inputPhone;
                }
                if($user->birthdate == '') {
                    $user->birthdate = $request->inputBirthdate;
                }    
                $user->save();
            }

            $sales->relationship = $request->inputRelationship;
            $sales->job = $request->inputPekerjaan;
    
            $item_id = $request->id;
            $item_question = $request->question;
            $item_genderquestion = 'Saya '.$request->genderQuestion[0].', mencari '.$request->genderQuestion2[0];
            // $item_genderquestion = $request->genderQuestion;
            // dd($item_genderquestion);
    
            foreach ($item_id as $key => $i) {
                $sku = SKUs::find($item_id[$key]);
                if($sku) {
                    if(strtolower($sku->products->title) != 'mencari jodoh') {
                        $sku->sales()->updateExistingPivot($sales, ['question' => $item_question[$key]]);
                    }
                    else {
                        $sku->sales()->updateExistingPivot($sales, ['question' => $item_genderquestion]);
                    }
                }
            }

    
            // Check product category in sales
            $is_product = 0;
            foreach ($sales->skus as $item) {
                if($item->products->category === 'product') {
                    $is_product += 1;
                }
            }
    
            if($is_product > 0) {
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
            }
            
            $sales->save();
            return redirect()->route('sales.summary', ['id' => $sales->sales_no]);
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
                CURLOPT_URL => "https://pro.rajaongkir.com/api/city?id=".$a->ship_city."&province=".$a->ship_province,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: ".env('RAJAONGKIR_KEY')
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
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ".env('RAJAONGKIR_KEY')
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
        if(Cache::has('cities_'.$request->id)) {
            $response = Cache::get('cities_'.$request->id);
        }
        else {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=".$request->id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ".env('RAJAONGKIR_KEY')
            ),
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
            Cache::put('cities_'.$request->id, $response, now()->addMinutes(1440));
        }
        $city = json_decode($response);
        $cities = $city->rajaongkir->results;

        return $cities;
    }

    public function checkShippingCost(Request $request)
    {
        $shippingAddress = ShippingAddress::where('id', $request->id)->firstOrFail();

        //TIKI
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=153&originType=city&destination=".$shippingAddress->ship_city."&destinationType=city&weight=1000&courier=anteraja",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: ".env('RAJAONGKIR_KEY')
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $cost = json_decode($response);
        $costs = $cost->rajaongkir->results[0]->costs;
        // //add courier name
        // $cost_jne = $cost[0]->rajaongkir->results[0]->costs;
        // foreach($cost_jne as $jne) {
        //     $jne->courier = 'JNE';
        // }
        // $cost_tiki = $cost[1]->rajaongkir->results[0]->costs;
        // foreach($cost_tiki as $tiki) {
        //     $tiki->courier = 'TIKI';
        // }

        // //merge
        // $shipcosts = $cost_tiki;
        
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
                if(Cache::has('address_'.$sales->shippingAddress->ship_city.'_'.$sales->shippingAddress->ship_province)) {
                    $response = Cache::get('address_'.$sales->shippingAddress->ship_city.'_'.$sales->shippingAddress->ship_province);
                }
                else {
                    $curl = curl_init();
                
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?id=".$sales->shippingAddress->ship_city."&province=".$sales->shippingAddress->ship_province,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                        "key: ".env('RAJAONGKIR_KEY')
                        ),
                    ));
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    Cache::put('address_'.$sales->shippingAddress->ship_city.'_'.$sales->shippingAddress->ship_province, $response, now()->addMinutes(1440));
                }
                
                $result = json_decode($response);
        
                $sales->shippingAddress->province = $result->rajaongkir->results->province;
                $sales->shippingAddress->city = $result->rajaongkir->results->type." ".$result->rajaongkir->results->city_name;
            }

            $skuvalues = SKUvalues::all();
            $values = array();
            $values_collection = collect();
            foreach ($skuvalues as $key => $skuvalue) {
                foreach($sales->skus as $key => $sku) {
                    if($sku->id == $skuvalue->sku_id) {
                        $value_datas = OptionValues::where('id', $skuvalue->value_id)->pluck('value_name');
                        $value_name = $value_datas->implode(',', 'value_name');
                        array_push($values, $value_name);
                        $sku->setAttribute('variants', $values);
                    }
                }
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
    
                if($discount && $discount->products->count() < 1) {
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
                elseif($discount && $discount->products->count() >= 1) {
                    foreach($sales->skus as $item) {
                        foreach($discount->products as $disc_product) {
                            if($item->products->id == $disc_product->id) {
                                if($disc_product->price >= $discount->min_total) {
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

        $is_product = 0;
        $is_service = 0;

        foreach ($sales->products as $item) {
            if($item->category === 'product') {
                $is_product += 1;
            }

            if($item->category === 'service') {
                $is_service += 1;
            }
        }

        if($user->id == $sales->user_id) {
            $paymentMethods = PaymentMethods::all();
            $is_soldout = 0;
            foreach($sales->products as $item) {
                $product = Products::where('id', $item->id)->where('category', 'product')->where('stock', '<=', 0)->first();
                if($product) {
                    $is_soldout = 1;
                }
            }
    
            return view('checkout.confirm-payment', compact('sales', 'paymentMethods', 'is_soldout', 'is_service'));
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

            $is_soldout = 0;
            foreach($sales->skus as $item) {
                $product = Products::where('id', $item->products->id)->where('category', 'product')->first();
                if($product) {
                    $sku_stock = SKUs::where('id', $item->id)->where('stock', '<=', 0)->first();
                    if($sku_stock) {
                        $is_soldout = 1;
                    }
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
                $sales->status = 'paid';
                $sales->save();
    
                // $sales->paymethod_id = $request->inputPayType;
                // $sales->status = 'paid';
                // $sales->save();
        
                // Mail::send(new UserTransaction($sales));
                //Mail::send(new AdminNotification($sales));
    
                foreach($sales->skus as $item) {
                    $sku = SKUs::find($item->id);
                    $sku->stock = $sku->stock-$item->pivot->qty;
                    $sku->save();
                }
        
                // Mail::send(new UserTransaction($sales));
                // Mail::send(new AdminNotification($sales));
        
                return redirect()->route('sales.success', ['id' => $sales->sales_no]);
            }
            elseif($is_soldout === 1) {
                return redirect()->back()->with('soldout');
            }

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
