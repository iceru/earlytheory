<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use Illuminate\Http\Request;
use Storage;

class AdminPerfumeController extends Controller
{
     public function index()
    {
        $perfumes = Perfume::all();

        return view('admin.perfume.index', compact('perfumes'));
    }

    public function store(Request $request)
    {
        $slider = new Perfume();

        $request->validate([
            'image' => 'required|image',
            'title' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = 'slider_'.time().'.'.$extension;
            $request->image->storeAs('public/perfume-image', $filename);
        }

        $slider->title = $request->title;
        $slider->image = $filename;
        $slider->save();

        return redirect('/admin/perfume');
    }

    public function edit($id)
    {
        $perfume = Perfume::findOrFail($id);

        return view('admin.perfume.edit', compact('perfume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $perfume = Perfume::find($request->id);

        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $request->updateTitle.'_'.time().'.'.$extension;
            $request->image->storeAs('public/perfume-image', $filename);
            $perfume->image = $filename;
        }

        $perfume->title = $request->title;
        $perfume->save();

        return redirect('/admin/perfume');
    }

    public function destroy($id)
    {
        $slider = Perfume::findOrFail($id);
        Storage::disk('public')->delete('perfume-image/'.$slider->image);

        Perfume::find($id)->delete();
        return redirect('/admin/perfume');
    }
}
