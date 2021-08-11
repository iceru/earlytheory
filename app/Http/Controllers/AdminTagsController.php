<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Articles;
use Illuminate\Http\Request;

class AdminTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tags::all();

        return view('admin.tags.index', compact('tags'));
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
        $tag = new Tags;

        $request->validate([
            'inputName' => 'required'
        ]);

        $tag->tag_name = $request->inputName;
        $tag->save();

        return redirect('/admin/tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tags::findOrFail($id);
        $articles = $tag->articles()->paginate(12);

        return view('tag-detail', compact('tag', 'articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tags::findOrFail($id);

        return view('admin.tags.edit', compact('tag'));
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
        $tag = Tags::find($request->id);

        $request->validate([
            'updateName' => 'required'
        ]);

        $tag->tag_name = $request->updateName;

        $tag->save();

        return redirect('/admin/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tags::find($id)->delete();
        return redirect('/admin/tags');
    }
}
