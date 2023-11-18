<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Workshop;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $courses = Course::where('workshop_id', $id)->get();
        $workshop = Workshop::where('id', $id)->first();

        return view('admin.courses.index', compact('courses', 'workshop'));
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
        $course = new Course;

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'video' => 'nullable',
            'time' => 'required|integer',
            'workshop_id' => 'required',
            'price' => 'required',
        ]);
        $filename;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug(strtolower($request->title)).'_'.time().'.'.$extension;
            $path = $request->image->storeAs('public/course-image', $filename);
        }

        if ($request->hasFile('video')) {
            $extension = $request->file('video')->getClientOriginalExtension();
            $videoFile =  Str::slug(strtolower($request->title)).'_'.time().'.'.$extension;
           
            $path = $request->video->storeAs('course-video', $videoFile, 'videos');
            $workshop->video = $videoFile;
        }

        $course->image = $filename;
        $course->title = $request->title;
        $course->slug = Str::slug(strtolower($request->title));
        $course->description = $request->description;
        $course->time = $request->time;
        $course->workshop_id = $request->workshop_id;
        $course->price = $request->price;
        $course->save();

        return redirect()->route('admin.courses', $request->workshop_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);

        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = Course::where('id', $id)->first();

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'video' => 'nullable',
            'time' => 'required|integer',
            'price' => 'required',
        ]);

        $filename;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename =  Str::slug(strtolower($request->title)).'_'.time().'.'.$extension;
            $path = $request->image->storeAs('public/course-image', $filename);
            $course->image = $filename;
        }   

        if ($request->hasFile('video')) {
            $extension = $request->file('video')->getClientOriginalExtension();
            $videoFile = Str::slug(strtolower($request->title)).'_'.time().'.'.$extension;
            $path = $request->video->storeAs('course-video', $videoFile, 'videos');
            $course->video = $videoFile;
        }

        $course->title = $request->title;
        $course->slug = Str::slug(strtolower($request->title));
        $course->description = $request->description;
        $course->time = $request->time;
        $course->price = $request->price;
        $course->save();

        return redirect()->route('admin.courses', $course->workshop_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::find($id)->delete();
      
        return redirect()->back();
    }
}
