<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class AdminWorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workshops = Workshop::all();

        return view('admin.workshops.index', compact('workshops'));
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
        $workshop = new Workshop;

        $request->validate([
            'image' => 'required|image',
            'title' => 'required',
            'description' => 'required',
            'video' => 'nullable',
            'time' => 'required|integer',
            'discount' => 'nullable',
        ]);
        $filename;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $request->title.'_'.time().'.'.$extension;
            $path = $request->image->storeAs('public/workshop-image', $filename);
        }

        if ($request->hasFile('video')) {
            $extension = $request->file('video')->getClientOriginalExtension();
            $videoFile = $request->title.'_'.time().'.'.$extension;
            $path = $request->video->storeAs('public/workshop-video', $videoFile);
            $workshop->video = $videoFile;
        }

        $workshop->image = $filename;
        $workshop->title = $request->title;
        $workshop->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title);
        $workshop->description = $request->description;
        $workshop->time = $request->time;
        $workshop->discount = $request->discount;
        $workshop->save();

        return redirect()->route('admin.workshops');
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
        $workshop = Workshop::find($id);

        return view('admin.workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $workshop = Workshop::find($request->id);

        $request->validate([
            'image' => 'nullable',
            'title' => 'required',
            'description' => 'required',
            'video' => 'nullable',
            'time' => 'required|integer',
            'discount' => 'nullable',
        ]);

        $filename;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $request->title.'_'.time().'.'.$extension;
            $path = $request->image->storeAs('public/workshop-image', $filename);
            $workshop->image = $filename;
        }

        if ($request->hasFile('video')) {
            $extension = $request->file('video')->getClientOriginalExtension();
            $videoFile = $request->title.'_'.time().'.'.$extension;
            $path = $request->video->storeAs('public/workshop-video', $videoFile);
            $workshop->video = $videoFile;
        }

        $workshop->title = $request->title;
        $workshop->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title);
        $workshop->description = $request->description;
        $workshop->time = $request->time;
        $workshop->discount = $request->discount;
        $workshop->save();

        return redirect()->route('admin.workshops');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Workshop::find($id)->delete();
      
        return redirect()->route('admin.workshops');
    }
}
