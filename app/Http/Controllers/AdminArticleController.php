<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();

        return view('admin.articles.index', compact('articles'));
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
        $article = new Article;

        $request->validate([
            'inputTitle' => 'required',
            'inputDesc' => 'required',
            'inputAuthor' => 'required',
            'inputTime' => 'required|integer',
            'inputAccent' => 'required'
        ]);

        $article->title = $request->inputTitle;
        $article->description = $request->inputDesc;
        $article->author = $request->inputAuthor;
        $article->time_read = $request->inputTime;
        $article->accent_color = $request->inputAccent;

        $article->save();

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
        $article = Article::findOrFail($id);

        return view('admin.articles.edit', compact('article'));
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
        $article = Article::find($request->id);

        $request->validate([
            'updateTitle' => 'required',
            'updateDesc' => 'required',
            'updateAuthor' => 'required',
            'updateTime' => 'required|integer',
            'updateAccent' => 'required'
        ]);

        $article->title = $request->updateTitle;
        $article->description = $request->updateDesc;
        $article->author = $request->updateAuthor;
        $article->time_read = $request->updateTime;
        $article->accent_color = $request->updateAccent;

        $article->save();

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
        Article::find($id)->delete();
        return redirect('/admin/articles');
    }
}
