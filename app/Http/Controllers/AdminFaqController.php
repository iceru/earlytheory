<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
    *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq = FAQ::all();
        return view('admin.faq.index', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function display() {
        $faq = FAQ::all();
        return view ('faq', compact('faq'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $faq = new FAQ;

        $request->validate([
            'inputTitle' => 'required',
            'inputQuestion' => 'required',
        ]);

        $faq->title = $request->inputTitle;
        $faq->question = $request->inputQuestion;
        $faq->save();

        return redirect('/admin/faq');
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
        $faq = FAQ::find($id);

        return view('admin.faq.edit', compact('faq'));
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
        $faq = FAQ::find($request->id);

        $request->validate([
            'updateTitle' => 'required',
            'updateQuestion' => 'required'
        ]);


        $faq->title = $request->updateTitle;
        $faq->question = $request->updateQuestion;
        $faq->save();

        return redirect('/admin/faq');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
