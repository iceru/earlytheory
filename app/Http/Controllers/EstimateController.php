<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index()
    {
        $estimate = Estimate::all();
    
        return view('admin.estimate.index', compact('estimate'));
    }

    public function store(Request $request)
    {
        $estimate = new Estimate;

        $request->validate([
            'title' => 'required',
            'estimate' => 'required'
        ]);

        $estimate->title = $request->title;
        $estimate->estimate = $request->estimate;

        $estimate->save();

        return redirect('/admin/estimate');
    }

    public function edit($id)
    {
        $estimate = Estimate::findOrFail($id);

        return view('admin.estimate.edit', compact('estimate'));
    }

    public function update(Request $request)
    {
        $estimate = Estimate::find($request->id);

        $request->validate([
            'title' => 'required',
            'estimate' => 'required',
        ]);

        $estimate->title = $request->title;
        $estimate->estimate = $request->estimate;

        $estimate->save();

        return redirect('/admin/estimate');
    }

    public function destroy($id)
    {
        Estimate::find($id)->delete();
        return redirect('/admin/estimate');
    }
}
