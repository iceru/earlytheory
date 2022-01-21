<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Horoscope;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\SKUs;

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

        // dd($horoscope_product);

        // $client = new Client();
        // $token = '378083|mZUVK0Rvi5CbUw7697VHUYsVD3EMkBA0EZN5AMHn';
        // $response = $client->request('POST', 'https://api.bloom.be/api/places', [
        //     'headers' => [
        //         'Authorization' => 'Bearer '.$token,
        //         'Accept' => 'application/json',
        //     ],
        //     'form_params' => [
        //         'name' => 'Depok'
        //     ]
        // ]);
        
        return view('horoscope', compact('user', 'horoscope_product', 'skus'));
    }

    public function places(Request $request)
    {
        if($request->ajax()) {
            $name = $request->name;
            $token = '7zep2FuuT1alaVjYtgiyFV2noJvjOIwYzvAOXHCUOfpI0p3D';
            $client = new Client();

            $response = $client->request('GET', 'https://astroapp.com/astro/apis/locations/name', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                    'content-type' => 'application/json'
                ],
                'form_params' => [
                    'cityName' => 'Jakarta',
                    'countryID' => 'id',
                    'stateCode' => '' 
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
            $token = '7zep2FuuT1alaVjYtgiyFV2noJvjOIwYzvAOXHCUOfpI0p3D';
            $client = new Client();

            $response = $client->request('POST', 'https://astroapp.com/astro/apis/chart', [
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
                    "system" => "p"
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function show(Horoscope $horoscope)
    {
        //
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
