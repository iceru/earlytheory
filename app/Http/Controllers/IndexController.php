<?php

namespace App\Http\Controllers;

use Newsletter;
use App\Models\Sliders;
use App\Models\Articles;
use App\Models\Products;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Products::where('category', 'service')->orderBy('ordernumber')->get();
        $products = Products::where('category', 'product')->orderByRaw('stock = 0, ordernumber')->get();
        $articles = Articles::orderBy('created_at', 'desc')->paginate(10);
        $sliders = Sliders::where('category', 'products')->orderBy('ordernumber')->get();

        if ($request->ajax()) {
            return view('article-index', ['articles' => $articles])->render();  
        }

        return view('index', compact('products', 'sliders', 'services', 'articles'));
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
        if ( ! Newsletter::isSubscribed($request->email) )
        {
            Newsletter::subscribe($request->email);
            return \Response::json(['success' => 'Thank you for Subscribing to our Newsletter']);
        }

        else {
            return \Response::json(['error' => 'You already Subscribed!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
