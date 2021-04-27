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
            'inputImage' => 'required|image'
        ]);

        if ($request->hasFile('inputImage')) {
            $extension = $request->file('inputImage')->getClientOriginalExtension();
            $filename = 'slider_'.time().'.'.$extension;
            $path = $request->inputImage->storeAs('public/sliders-image', $filename);
        }

        $slider->image = $filename;
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
