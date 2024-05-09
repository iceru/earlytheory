<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Workshop;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Storage;

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
            'time' => 'required|integer',
            'workshop_id' => 'required',
            'price' => 'required',
        ]);
        $filename;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug(strtolower($request->title)) . '_' . time() . '.' . $extension;
            $request->image->storeAs('public/course-image', $filename);
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

    public function addvideo($id)
    {
        $course = Course::find($id);

        return view('admin.courses.upload-video', compact('course'));
    }
    public function addvideolq($id)
    {
        $course = Course::find($id);

        return view('admin.courses.upload-video-lq', compact('course'));
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
            'time' => 'required|integer',
            'price' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug(strtolower($request->title)) . '_' . time() . '.' . $extension;
            $request->image->storeAs('public/course-image', $filename);
            $course->image = $filename;
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

    public function video(Request $request, $id)
    {
        $course = Course::where('id', $id)->first();

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
    
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
    
            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('videos/course-video', $file, $fileName);
            $course->video = $fileName;
            $course->save();
    
            // delete chunked file
            unlink($file->getPathname());
            return [
                'success' => true
            ];
        }
    
        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function videolq(Request $request, $id)
    {
        $course = Course::where('id', $id)->first();

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
    
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_lq_' . md5(time()) . '.' . $extension; // a unique file name
    
            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('videos/course-video', $file, $fileName);
            $course->lq_video = $fileName;
            $course->save();
    
            // delete chunked file
            unlink($file->getPathname());
            return [
                'success' => true
            ];
        }
    
        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
}
