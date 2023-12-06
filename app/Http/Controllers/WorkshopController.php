<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Course;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $workshops = Workshop::all();
        return view('workshop/workshop', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $workshop = Workshop::where('slug', $slug)->firstOrFail();
        $fullPrice = 0;
        $discountPrice = null;

        $alreadyBuy = false;
        foreach($workshop->course as $course) {
            $fullPrice = $course->price + $fullPrice;

            foreach($course->sales as $sale) {
                if($sale->status == 'settlement') {
                    $alreadyBuy = true;
                    $course->status = 'active';
                }
            }
        }
        if($workshop->discount) {
            $fullPrice = $fullPrice - ($fullPrice * $workshop->discount / 100);
        }
        return view('workshop/workshop-detail', compact('workshop', 'fullPrice', 'alreadyBuy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshop $workshop) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workshop $workshop) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop) {
        //
    }
}
