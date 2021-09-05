<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addCheckout(Request $request)
    {
        $user = Auth::user();
    
        $address = new ShippingAddress;

        $request->validate([
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'zip' => 'required',
        ],
        [
            'address.required' => 'Alamat belum diisi',
            'province.required' => 'Provinsi belum diisi',
            'city.required' => 'Kota/Kab belum diisi',
            'zip.required' => 'Kode Pos belum diisi',
        ]);

        $address->ship_address = $request->address;
        $address->ship_province = $request->province;
        $address->ship_city = $request->city;
        $address->ship_zip = $request->zip;
        $address->user_id = $user->id;
        $address->save();

        return \Response::json(['success' => 'Alamat telah ditambahkan']);
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();
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
        
        $html = view('checkout.select-address', compact('address'))->render();

        return response()->json(compact('html'));
    }
}
