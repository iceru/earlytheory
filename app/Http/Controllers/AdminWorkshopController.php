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
            'color' => 'required',
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
        $workshop->color = $request->color;
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
        $workshop = Articles::find($id);
        $autocomplete = Tags::pluck('tag_name')->toArray();

        return view('admin.articles.edit', compact('article', 'autocomplete'));
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
        $workshop = Articles::find($request->id);

        $request->validate([
            'updateImage' => 'image|nullable',
            'updateTitle' => 'required',
            'updateDesc' => 'required',
            'updateAuthor' => 'required',
            'updateTime' => 'required|integer',
            'updateAccent' => 'required',
            'updateTags' => 'string|regex:/^[a-zA-Z0-9\s]+$/'
        ]);

        if ($request->hasFile('updateImage')) {
            $extension = $request->file('updateImage')->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = $request->updateImage->storeAs('public/article-image', $filename);
            $workshop->image = $filename;
        }

        $workshop->title = $request->updateTitle;
        $workshop->description = $request->updateDesc;
        $workshop->author = $request->updateAuthor;
        $workshop->time_read = $request->updateTime;
        $workshop->accent_color = $request->updateAccent;
        $workshop->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->updateTitle);
        $workshop->save();

        $tagsArray = explode(' ', strtolower($request->updateTags));
        $tags = array();

        foreach($tagsArray as $workshopTag) {
            if($workshopTag != ' ') {
                $tag = Tags::firstOrCreate([
                    'tag_name' => $workshopTag
                ]);

                $tags[$tag->id] = ['article_id' => $request->id];
            }
        }
        $workshop->tags()->sync($tags);

        return redirect('/admin/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Articles::find($id)->delete();
        return redirect('/admin/articles');
    }

    public function upload(Request $request){
        $fileName=$request->file('file')->getClientOriginalName();
        $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        return response()->json(['location'=>"/storage/$path"]); 
    }
}
