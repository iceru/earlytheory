<?php

namespace App\Http\Controllers;

use File;
use App\Models\SKUs;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Products;
use App\Models\Horoscope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HoroscopeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $horoscope_product = Products::where('title', 'horoscope')->first();
        $skus = SKUs::where('product_id', $horoscope_product->id)->get();
        
        return view('horoscope', compact('user', 'horoscope_product', 'skus'));
    }

    public function places(Request $request)
    {
        if($request->ajax()) {
            $name = $request->name;
            $token = '493092|qpniVPdE0nv7nHjyMbOM2YSQTVzF0DsI0lMtG3yC';
            $client = new Client();

            $response = $client->request('POST', 'https://api.bloom.be/api/places', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'name' => $name
                ]
            ]);
            $data = json_decode($response->getBody()->getContents());
            return response()->json($data, 200);
        }

        return response()->json('Error', 400);
    }

    public function natal(Request $request)
    {
        if($request->ajax()) {
            $name = $request->name;
            $token = '493092|qpniVPdE0nv7nHjyMbOM2YSQTVzF0DsI0lMtG3yC';
            $client = new Client();

            $response = $client->request('POST', 'https://api.bloom.be/api/natal', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'name' => $request->name,
                    "date" => $request->date,
                    "time" => $request->time,
                    "place_id"=> $request->place_id,
                    "lang" => "en",
                    "system" => "p",
                    "wheelSettings" => $request->wheelSettings,
                ]
            ]);
            // $data = json_decode($response->getBody()->getContents());
            $data = $response->getBody()->getContents();
            return response()->json($data, 200);
        }

        return response()->json('Error', 400);
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
        $horoscope = new Horoscope;

        $request->validate([
            'user_id' => 'nullable',
            'data' => 'required',
            'link_id' => 'required',
            'name' => 'nullable',
            'email' => 'nullable',
            'places' => 'required',
        ]);

        $horoscope->user_id = $request->user_id;
        $horoscope->data = $request->data;
        $horoscope->link_id = $request->link_id;
        $horoscope->name = $request->name;
        $horoscope->email = $request->email;
        $horoscope->places = $request->places;

        $horoscope->save();
        
        $url = $request->data['wheel'];
        $contents = file_get_contents($url);
        $name = 'public/horoscopes/horoscope_'.$request->link_id.'.svg';
        Storage::put($name, $contents);

        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function show($link_id)
    {
        $user = Auth::user();
        $horoscope = Horoscope::where('link_id', $link_id)->firstOrFail();
        $horoscope_product = Products::where('title', 'horoscope')->first();
        $skus = SKUs::where('product_id', $horoscope_product->id)->get();
        
        // dd($horoscope->data);
        return view('horoscope-detail', compact('horoscope', 'skus', 'horoscope_product', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function edit(Horoscope $horoscope)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horoscope $horoscope)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horoscope $horoscope)
    {
        //
    }
}
