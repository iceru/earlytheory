<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $course = Course::where('slug', $slug)->firstOrFail();
        $workshop = Workshop::where('id', $course->workshop_id)->firstOrFail();
        $paid = false;
        foreach($course->sales as $courseSale) {
            if($courseSale->status === 'settlement') {
                $paid = true;
            }
        }
        if(!$paid) {
            return redirect()->route('workshop.detail', $workshop->slug);
        }
        $coIndex = $workshop->course->search(function ($co) use ($course) {
            return $co->id === $course->id;
        });
        $coIndex = $coIndex + 1;

        $nextCourse = null;
        $prevCourse = null;
        $enableNext = false;

        foreach($workshop->course as $key => $item) {
            if($key === $coIndex) {
                foreach($item->sales as $saleNext) {
                    if($saleNext->status === 'settlement') {
                        $enableNext = true;
                        $nextCourse = $item;
                    }
                }
            }
            if($coIndex > 1 && $key === $coIndex - 2) {
                $prevCourse = $item;
            }
        }
        return view('workshop/course', compact('course', 'workshop', 'coIndex', 'enableNext', 'nextCourse', 'prevCourse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course) {
        //
    }

    public function showVideo($slug) {
        /**
         *Make sure the @param $file has a dot
         * Then check if the user has Admin Role. If true serve else
         */
        $course = Course::where('slug', $slug)->first();
        if($course->video && $course->sales) {
            foreach($course->sales as $sale) {
                if($sale->status === 'settlement') {
                    try {
                        $video = Storage::disk('videos')->get("course-video/$course->video");
                        $response = \Response::make($video, 200);
                        $response->header('Content-Type', 'video/mp4');
                        return $response;
                    } catch (Exception $e) {
                        echo $e;
                    }
                } else {
                    // return redirect()->route('index');
                }
            }
        } else {
            return redirect()->route('index');
        }
    }
}
