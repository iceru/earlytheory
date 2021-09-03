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
            'inputAddress' => 'required',
            'inputProvince' => 'required',
            'inputCity' => 'required',
            'inputZip' => 'required',
        ],
        [
            'inputAddress.required' => 'Alamat belum diisi',
            'inputProvince.required' => 'Provinsi belum diisi',
            'inputCity.required' => 'Kota/Kab belum diisi',
            'inputZip.required' => 'Kode Pos belum diisi',
        ]);

        $address->ship_address = $request->inputAddress;
        $address->ship_province = $request->inputProvince;
        $address->ship_city = $request->inputCity;
        $address->ship_zip = $request->inputZip;
        $address->user_id = $user->id;
        $address->save();

        return redirect()->route('sales.shipping', ['id' => $request->salesNo]);
    }
}
