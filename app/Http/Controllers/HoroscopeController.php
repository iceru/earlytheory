<?php

namespace App\Http\Controllers;

use App\Models\Horoscope;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HoroscopeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client();
        $token = '378083|mZUVK0Rvi5CbUw7697VHUYsVD3EMkBA0EZN5AMHn';
        $response = $client->request('POST', 'https://api.bloom.be/api/places', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'name' => 'Depok'
            ]
        ]);

        return view('horoscope', compact('response'));
    }

    public function places(Request $request)
    {
        if($request->ajax()) {
            $name = $request->name;
            $token = '378083|mZUVK0Rvi5CbUw7697VHUYsVD3EMkBA0EZN5AMHn';
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
            $token = '378083|mZUVK0Rvi5CbUw7697VHUYsVD3EMkBA0EZN5AMHn';
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
                    "system" => "p"
                ]
            ]);
            $data = json_decode($response->getBody()->getContents());
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
