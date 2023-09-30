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
        $article = new Articles;

        $request->validate([
            'inputImage' => 'required|image',
            'inputTitle' => 'required',
            'inputDesc' => 'required',
            'inputAuthor' => 'required',
            'inputTime' => 'required|integer',
            'inputAccent' => 'required',
            'inputTags' => 'string|regex:/^[a-zA-Z0-9\s]+$/'
        ]);

        if ($request->hasFile('inputImage')) {
            $extension = $request->file('inputImage')->getClientOriginalExtension();
            $filename = $request->inputTitle.'_'.time().'.'.$extension;
            $path = $request->inputImage->storeAs('public/article-image', $filename);
        }

        $article->image = $filename;

        $article->title = $request->inputTitle;
        $article->description = $request->inputDesc;
        $article->author = $request->inputAuthor;
        $article->time_read = $request->inputTime;
        $article->accent_color = $request->inputAccent;
        $article->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->inputTitle);
        $article->save();

        $tagsArray = explode(' ', strtolower($request->inputTags));
        $tags = array();

        foreach($tagsArray as $articleTag) {
            if($articleTag != ' ') {
                $tag = Tags::firstOrCreate([
                    'tag_name' => $articleTag
                ]);

                $tags[$tag->id] = ['article_id' => $article->id];
            }
        }

        $article->tags()->attach($tags);

        return redirect('/admin/articles');
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
        $article = Articles::find($id);
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
        $article = Articles::find($request->id);

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
            $article->image = $filename;
        }

        $article->title = $request->updateTitle;
        $article->description = $request->updateDesc;
        $article->author = $request->updateAuthor;
        $article->time_read = $request->updateTime;
        $article->accent_color = $request->updateAccent;
        $article->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->updateTitle);
        $article->save();

        $tagsArray = explode(' ', strtolower($request->updateTags));
        $tags = array();

        foreach($tagsArray as $articleTag) {
            if($articleTag != ' ') {
                $tag = Tags::firstOrCreate([
                    'tag_name' => $articleTag
                ]);

                $tags[$tag->id] = ['article_id' => $request->id];
            }
        }
        $article->tags()->sync($tags);

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
