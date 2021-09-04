<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use App\Models\ShippingAddress;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class AdminSalesController extends Controller
{
    public function index()
    {
        $sales = Sales::all();

        return view('admin.sales.index', compact('sales'));
    }

    public function detail($id)
    {
        $sales = Sales::find($id);

        if($sales->address_id) {
            // foreach($sales as $s) {
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
            // }
        }

        return view('admin.sales.detail', compact('sales'));
    }

    public function destroy($id)
    {
        $delete = Sales::find($id)->delete();
        // check data deleted or not
        if ($delete == 1) {
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
        // return redirect('/admin/sales');
    }
}
