<?php

namespace App\Http\Controllers;

use App\Models\Sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlidersController extends Controller
{
    public function index()
    {
        $sliders = Sliders::all();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $slider = new Sliders;

        $request->validate([
            'inputImage' => 'required|image',
            'inputLink' => 'required',
            'inputCategory' => 'required'
        ]);

        if ($request->hasFile('inputImage')) {
            $extension = $request->file('inputImage')->getClientOriginalExtension();
            $filename = 'slider_'.time().'.'.$extension;
            $path = $request->inputImage->storeAs('public/sliders-image', $filename);
        }

        $slider->link = $request->inputLink;
        $slider->category = $request->inputCategory;
        $slider->image = $filename;
        $slider->save();

        return redirect('/admin/sliders');
    }

    public function edit($id)
    {
        $slider = Sliders::findOrFail($id);

        return view('admin.sliders.edit', compact('slider'));
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
        $slider = Sliders::find($request->id);

        $request->validate([
            'updateImage' => 'image|nullable',
            'updateLink' => 'required',
            'updateCategory' => 'required',
        ]);

        if ($request->hasFile('updateImage')) {
            $extension = $request->file('updateImage')->getClientOriginalExtension();
            $filename = $request->updateTitle.'_'.time().'.'.$extension;
            $path = $request->updateImage->storeAs('public/sliders-image', $filename);
            $slider->image = $filename;
        }

        $slider->link = $request->updateLink;
        $slider->category = $request->updateCategory;
        $slider->save();

        return redirect('/admin/sliders');
    }

    public function destroy($id)
    {
        $slider = Sliders::findOrFail($id);
        Storage::disk('public')->delete('sliders-image/'.$slider->image);

        Sliders::find($id)->delete();
        return redirect('/admin/sliders');
    }
}
