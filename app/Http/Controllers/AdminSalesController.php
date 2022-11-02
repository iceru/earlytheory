<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\SKUs;
use App\Models\Sales;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\ShippingAddress;
use App\Models\AdditionalQuestion;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;

class AdminSalesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sales = Sales::with('user')->with('paymentmethods')->with('additional')->where('status', 'settlement')->orderBy('created_at', 'desc');

            return Datatables::of($sales)
            ->addIndexColumn()
                ->editColumn('name', function ($row) {  //this example  for edit your columns if colums is empty 
                    $fname = !empty($row->user->name) ? $row->user->name : $row->name;
                    return $fname;
                })
                ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M Y'); return $formatedDate; })
                ->addColumn('image', function ($sale) {
                    $url= asset('storage/payment-proof/'.$sale->payment);
                    return '<img src="'.$url.'" width="100"/>';
                })
                ->addColumn('action', function ($sale) {
                    $additional = '';
                    if(!empty($sale->additional[0]->id)) {
                        $additional = '<a href="/admin/additional/'.$sale->id.'" class="button secondary d-flex align-items-center btn-sm mt-2 justify-content-center"><i class="fa fa-list" aria-hidden="true"></i> <span class="ms-1">Additional</span></a>';
                    };
                    return '<a href="/admin/sales/'.$sale->id.'" class="btn btn-primary d-flex align-items-center btn-sm mb-2 justify-content-center w-100"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="ms-1">Detail</span></a>
                    <button onclick="deleteConfirmation('.$sale->id.')" class="btn btn-danger d-flex align-items-center btn-sm justify-content-center w-100"><i class="fas fa-trash"></i> <span class="ms-1">Delete</span></button>'.$additional.'';})
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        
        return view('admin.sales.index');
    }

    public function additional($id)
    {
        $additional = AdditionalQuestion::where('sales_id', $id)->firstOrFail();
        $skus = $additional->sales->skus;

        return view('admin.sales.additional', compact('additional', 'skus'));
    }

    public function detail($id)
    {
        $sales = Sales::findOrFail($id);

        if($sales->address_id) {
            // foreach($sales as $s) {
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
                        "key: 6647e093d8e3502f18a50d44d52e032a"
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
            // }
        }

        return view('admin.sales.detail', compact('sales'));
    }

    public function edit($id)
    {
        $sales = Sales::findOrFail($id);

        return view('admin.sales.edit', compact('sales'));
    }

    public function update(Request $request)
    {
        $sales = Sales::find($request->id);

        // $request->validate([
        //     'updateName' => 'required'
        // ]);

        $user_id = $sales->user_id;
        $user = User::find($user_id);

        $user->name = $request->updateName;
        $user->email = $request->updateEmail;
        $user->phone = $request->updatePhone;
        $user->birthdate = Carbon::parse($request->updateBirthdate)->format('Y-m-d');

        $user->save();

        return redirect('/admin/sales');
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
