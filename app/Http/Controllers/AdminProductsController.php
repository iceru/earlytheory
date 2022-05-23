<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\SKUs;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::where('category', 'product')->orderBy('ordernumber')->get();
        $services = Products::where('category', 'service')->orderBy('ordernumber')->get();
        $skus = SKUs::all();
        $options = Options::all();

        foreach ($skus as $key => $sku) {
            foreach ($products as $key => $product) {
                if($sku->product_id == $product->id && $product->category == 'product') {
                    $product->setAttribute('stock_data', $sku->stock);
                    foreach ($options as $key => $option) {
                        if($option->product_id == $product->id) {
                            $product->setAttribute('stock_data', 'Stock berdasarkan variants');
                            break;
                        } else {
                            $product->setAttribute('stock_data', $sku->stock);
                        }
                    }
                } else if ($product->category == 'service' || $product->category == null) {
                    $product->setAttribute('stock_data', '-');
                }
            }
        }

        return view('admin.products.index', compact('products', 'skus', 'options', 'services'));
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
        $product = new Products;

        $request->validate([
            'inputTitle' => 'required',
            'inputOrdernumber' => 'required',
            'inputPrice' => 'required|integer',
            'inputDiscPrice' => 'nullable|integer',
            'inputDuration' => 'nullable|integer',
            'inputImage' => 'required',
            'inputImage.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'inputShortDesc' => 'required',
            'inputDesc' => 'required',
            'inputCategory' => 'required|in:product,service',
            'inputStock' => 'required',
            'inputQuestion' => 'nullable',
            'inputQuestionTitle' => 'nullable',
        ]);

        if ($request->hasFile('inputImage')) {
            // $extension = $request->file('inputImage')->getClientOriginalExtension();
            // $filename = $request->inputTitle.'_'.time().'.'.$extension;
            // $path = $request->inputImage->storeAs('public/product-image', $filename);

            $images = $request->file('inputImage');

            foreach($images as $image) {
                $name = $image->getClientOriginalName();
                $filename = $request->inputTitle.'_'.time().'.'.$name;
                $path = $image->storeAs('public/product-image', $filename);
                $data[] = $filename;
            }
        }
        $product->image=json_encode($data);
        
        $product->title = $request->inputTitle;
        $product->ordernumber = $request->inputOrdernumber;

        //check discount price
        if($request->inputDiscPrice) {
            $product->price = $request->inputDiscPrice;
            $product->discount_price = $request->inputDiscPrice;
            $product->base_price = $request->inputPrice;
        }
        else {
            $product->price = $request->inputPrice;
        }

        $product->duration = $request->inputDuration;
        $product->description = $request->inputDesc;
        $product->description_short = $request->inputShortDesc;
        $product->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->inputTitle);
        $product->category = $request->inputCategory;
        $product->stock = $request->inputStock;
        $product->question = $request->inputQuestion;
        $product->question_title = $request->inputQuestionTitle;
        
        $product->save();

        // $request->validate([
        //     'inputPrice' => 'required|numeric',
        //     'inputStock' => 'required|numeric',
        //     'inputvarval' => 'required'
        // ]);

        // dd($request->inputvarval);

        $sku_new = new SKUs;
        // $sku_new->price = $request->inputPrice;

        //check discount price
        if($request->inputDiscPrice) {
            $sku_new->price = $request->inputDiscPrice;
            $sku_new->discount_price = $request->inputDiscPrice;
            $sku_new->base_price = $request->inputPrice;
        }
        else {
            $sku_new->price = $request->inputPrice;
        }
        
        $sku_new->stock = $request->inputStock;
        $sku_new->product_id = $product->id;
        $sku_new->save();


        // if(strlen($request->inputDesc) > 40) {
        //     $shortDesc = substr($request->inputDesc, 0, strpos($request->inputDesc, ' ', 40)).'...';
        // }
        // else {
        //     $shortDesc = $request->inputDesc;
        // }
        // $product->description_short = $shortDesc;


        return redirect('/admin/products');
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
        $product = Products::findOrFail($id);

        return view('admin.products.edit', compact('product'));
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
        $product = Products::find($request->id);

        $request->validate([
            'updateTitle' => 'required',
            'updateOrdernumber' => 'required',
            'updatePrice' => 'required|integer',
            'updateDiscPrice' => 'nullable|integer',
            'updateDuration' => 'nullable|integer',
            'updateImage' => 'nullable',
            'updateImage.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'updateDesc' => 'required',
            'updateCategory' => 'required|in:product,service',
            'updateStock' => 'required',
            'updateQuestion' => 'nullable',
            'updateQuestionTitle' => 'nullable',
        ]);

        if ($request->hasFile('updateImage')) {
            // $extension = $request->file('updateImage')->getClientOriginalExtension();
            // $filename = $request->updateTitle.'_'.time().'.'.$extension;
            // $path = $request->updateImage->storeAs('public/product-image', $filename);
            // $product->image = $filename;
            $images = $request->file('updateImage');

            foreach($images as $image) {
                $name = $image->getClientOriginalName();
                $filename = $request->inputTitle.'_'.time().'.'.$name;
                $path = $image->storeAs('public/product-image', $filename);
                $data[] = $filename;
            }
            $product->image = json_encode($data);
        }

        $product->title = $request->updateTitle;
        $product->ordernumber = $request->updateOrdernumber;
        $product->price = $request->updatePrice;

        //check discount price
        if($request->updateDiscPrice) {
            $product->price = $request->updateDiscPrice;
            $product->discount_price = $request->updateDiscPrice;
            $product->base_price = $request->updatePrice;
        }
        else {
            $product->price = $request->updatePrice;
        }
        
        $product->duration = $request->updateDuration;
        $product->description = $request->updateDesc;

        $product->description_short = $request->updateShortDesc;
        $product->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->updateTitle);
        $product->category = $request->updateCategory;
        $product->stock = $request->updateStock;
        $product->question = $request->updateQuestion;
        $product->question_title = $request->updateQuestionTitle;

        $product->save();

        $have_variant = Options::where('product_id', $request->id)->get();

        // dd($have_variant);
        if($have_variant->isEmpty()) {
            $sku = SKUs::where('product_id', $request->id)->firstOrFail();
            $sku->price = $request->updatePrice;
            // $sku->stock = $request->updateStock;
            $sku->product_id = $product->id;

            $sku->save();
            // dd($request->updateStock);
        }

        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        Storage::disk('public')->delete('product-image/'.$product->image);

        Products::find($id)->delete();
        return redirect('/admin/products');
    }

    public function hide($id)
    {
        $product = Products::find($id);
        $product->hide = 1;
        $product->save();

        return redirect('/admin/products');
    }

    public function unhide($id)
    {
        $product = Products::find($id);
        $product->hide = 0;
        $product->save();

        return redirect('/admin/products');
    }

    public function generateSKU()
    {
        $products = Products::get();

        foreach($products as $product) {
            $have_sku = SKUs::where('product_id', $product->id)->get();
            if($have_sku->isEmpty()) {
                $sku_new = new SKUs;
                // $sku_new->price = $product->price;
                        
                //check discount price
                if($product->discount_price) {
                    $sku_new->price = $product->price;
                    $sku_new->discount_price = $product->discount_price;
                    $sku_new->base_price = $product->base_price;
                }
                else {
                    $sku_new->price = $product->price;
                }
                
                $sku_new->stock = $product->stock;
                $sku_new->product_id = $product->id;
                $sku_new->save();
            }
        }

        return redirect()->back();
    }
}
