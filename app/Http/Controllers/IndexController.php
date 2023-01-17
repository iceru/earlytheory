<?php

namespace App\Http\Controllers;

use Newsletter;
use App\Models\SKUs;
use App\Models\Sliders;
use App\Models\Articles;
use App\Models\Products;
use App\Models\Horoscope;
use App\Models\SKUvalues;
use App\Models\OptionValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Products::where('category', 'service')->where('hide', 0)
        ->where('type', 'tarot')->orderBy('ordernumber')->get();
        $astrologi = Products::where('category', 'service')->where('hide', 0)
        ->where('type', 'astrologi')->orderBy('ordernumber')->get();
        $spiritual = Products::where('category', 'service')->where('hide', 0)
        ->where('type', 'spiritual')->orderBy('ordernumber')->get();
        $products = Products::where('category', 'product')->where('hide', 0)
        ->orderByRaw('stock = 0, ordernumber')->get();
        $articles = Articles::orderBy('created_at', 'desc')->paginate(12);
        $user = Auth::user();
        
        // $horoscope_product = Products::where('title', 'horoscope')->first();
        // $skus_horoscope = SKUs::where('product_id', $horoscope_product->id)->get();

        $sliders = Sliders::where('category', 'products')->orderBy('ordernumber')->get();

        $product_ids = array();
        $productsSku = Products::all();
        $skus = SKUs::all();
        $skusvalues = SKUvalues::get();
        $optionvalues = OptionValues::get();

        // Article paging
        // if ($request->ajax()) {
        //   return view('article-index', ['articles' => $articles])->render();
        // }

        foreach ($skus as $key => $sku) {
            foreach ($productsSku as $key => $product) {
                if($sku->product_id == $product->id && ($product->category == 'service' || $sku->stock > 0)) {
                    array_push($product_ids, $sku);
                }
            }
        }

        $array = $product_ids;
        $key = 'product_id';

        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }

        $values_name = array();

        foreach ($temp_array as $key => $sku) {
            foreach ($skusvalues as $key => $value) {
                if($sku->id == $value->sku_id) {
                    foreach ($optionvalues as $key => $option) {
                        if($value->option_id == $option->option_id && $value->value_id == $option->id) {
                            $value_datas = OptionValues::where('id', $value->value_id)->pluck('value_name');
                            $value_name = $value_datas->implode('', 'value_name');
                            array_push($values_name, $value_name);
                        }
                    }
                }
            }
            $sku->setAttribute('values', $values_name);
            $values_name = array();
        }
        
        $skus = json_encode($temp_array);
        return view('index', compact('products', 'sliders', 'services', 'articles',
        'skus', 'user', 'astrologi', 'spiritual'));
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
