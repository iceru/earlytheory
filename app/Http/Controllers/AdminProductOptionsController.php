<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Options;
use App\Models\OptionValues;
use App\Models\SKUs;
use App\Models\SKUvalues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductOptionsController extends Controller
{
    public function index($id)
    {
        $product = Products::find($id)->firstOrFail();
        $variants = Options::where('product_id', $id)->get();
        $skus = SKUs::where('product_id', $id)->get();
        // dd($variants);

        return view('admin.productOptions.index', compact('product', 'variants', 'skus'));
    }

    public function store(Request $request)
    {
        $product = Products::find($request->product_id)->firstOrFail();
        
        $variant = new Options;

        $request->validate([
            'inputVariant' => 'required',
            'inputVariantVal' => 'required'
        ]);

        $variant->option_name = $request->inputVariant;
        $variant->product_id = $request->product_id;
        $variant->save();

        $valArray = explode(',', $request->inputVariantVal);

        //input variant value(s)
        foreach($valArray as $value) {
            $variant_values = new OptionValues;
            $variant_values->value_name = $value;
            $variant_values->option_id = $variant->id;
            $variant_values->save();
        }
        
        // $total_variantval = 1;
        // $variant_collection = Options::where('product_id', $request->product_id)->get();
        // foreach($variant_collection as $var) {
        //     $variantval_collection = OptionValues::where('option_id', $var->id)->get();

        //     $count_varval = $variantval_collection->count();
        //     $total_variantval = $total_variantval*$count_varval;

        //     // foreach($variantval_collection as $val) {
        //     //     // $skucheck1 = SKUvalues::where('value_id', $val->id)->get();
        //     //     // if($skucheck1->isEmpty()) {
        //     //     //     $sku_new = new SKUs;
        //     //     //     $sku_new->price = $product->price;
        //     //     //     $sku_new->stock = 1;
        //     //     //     $sku_new->product_id = $request->product_id;
        //     //     //     $sku_new->save();

        //     //     //     // $skuval = new SKUvalues;
        //     //     //     // $skuval->sku_id = $sku_new->id;
        //     //     //     // $skuval->option_id = $var->id;
        //     //     //     // $skuval->value_id = $val->id;
        //     //     //     // $skuval->save();
                    
        //     //     // }
        //     // }
        // }

        // $sku_collection = SKUs::where('product_id', $request->product_id)->get();
        // $count_sku = $sku_collection->count();

        // $variant_collection = Options::where('product_id', $request->product_id)->get();

        // for($i=0;$i<$total_variantval-$count_sku;$i++) {
        //     $sku_new = new SKUs;
        //     $sku_new->price = $product->price;
        //     $sku_new->stock = 1;
        //     $sku_new->product_id = $request->product_id;
        //     $sku_new->save();

        //     // foreach($variant_collection as $var) {
        //     //     $variantval_collection = OptionValues::where('option_id', $var->id)->get();
        //     //     foreach($variantval_collection as $val) {
        //     //         $skuval = new SKUvalues;
        //     //         $skuval->sku_id = $sku_new->id;
        //     //         $skuval->option_id = $var->id;
        //     //         $skuval->value_id = $val->id;
        //     //         $skuval->save();
        //     //     }
        //     // }
        // }
        

        // foreach($sku_collection as $sku) {
        //     // $skucheck1 = SKUvalues::where('sku_id', $sku->id)->get();
        //     // if($skucheck1->isEmpty()) {
        //         foreach($variant_collection as $var) {
        //             // $skucheck1 = SKUvalues::where('sku_id', $sku->id)->where('option_id', $var->id)->get();
        //             // if($skucheck1->isEmpty()) {
        //                 $variantval_collection = OptionValues::where('option_id', $var->id)->get();
        //                 foreach($variantval_collection as $val) {
        //                     $same_sku = $variant_collection->count();
        //                     $sku_collection2 = SKUs::where('product_id', $request->product_id)->get();
        //                     foreach($sku_collection2 as $sku2) {
        //                         $skucheck = SKUvalues::where('sku_id', $sku2->id)->where('option_id', $var->id)->where('value_id', $val->id)->get();
        //                         if($skucheck->isNotEmpty()) {
        //                             $same_sku--;
        //                         }
        //                     }

        //                     $skucheck2 = SKUvalues::where('sku_id', $sku->id)->where('option_id', $var->id)->get();
        //                     if($same_sku == $variant_collection->count() && $skucheck2->isEmpty()) {
        //                         $skuval = new SKUvalues;
        //                         $skuval->sku_id = $sku->id;
        //                         $skuval->option_id = $var->id;
        //                         $skuval->value_id = $val->id;
        //                         $skuval->save();
        //                     }
        //                     // $skucheck2 = SKUvalues::where('sku_id', $sku->id)->where('option_id', $var->id)->get();
        //                     // $skucheck3 = SKUvalues::where('value_id', '!=', $val->id)->get();
        //                     // // $skucheck4 = SKUvalues::where('sku_id', '!=' , $sku->id)->where('option_id', '!=' , $var->id)->where('value_id', $val->id)->get();
        //                     // if($skucheck2->isEmpty()) {
        //                     //     $skuval = new SKUvalues;
        //                     //     $skuval->sku_id = $sku->id;
        //                     //     $skuval->option_id = $var->id;
        //                     //     $skuval->value_id = $val->id;
        //                     //     $skuval->save();
        //                     // }
        //                 }
        //             // }
        //         }
        //     // }
        // }

        // $skuval = new SKUvalues;
        // $skuval->sku_id = $sku->id;
        // $skuval->option_id = $var->id;
        // $skuval->value_id = $val->id;
        // $skuval->save();


        return redirect()->back();
    }

    public function storeSKU(Request $request)
    {
        $request->validate([
            'inputPrice' => 'required|numeric',
            'inputStock' => 'required|numeric',
            'inputvarval' => 'required'
        ]);

        // dd($request->inputvarval);

        $sku_new = new SKUs;
        $sku_new->price = $request->inputPrice;
        $sku_new->stock = $request->inputStock;
        $sku_new->product_id = $request->product_id;
        $sku_new->save();
        
        foreach($request->inputvarval as $varval) {
            $variant_values = explode('-', $varval);

            $skuval = new SKUvalues;
            $skuval->sku_id = $sku_new->id;
            $skuval->option_id = $variant_values[0];
            $skuval->value_id = $variant_values[1];
            $skuval->save();
        }


        return redirect()->back();
    }
    
    public function editVariant($id)
    {
        // $product = Products::find($id)->firstOrFail();
        $variant = Options::findOrFail($id);
        // dd($variant);
        
        return view('admin.productOptions.editvar', compact('variant'));
    }
    
    public function updateVariant(Request $request)
    {
        $variant = Options::find($request->id);
        
        $request->validate([
            'updateVariant' => 'required',
            'idVariantVal' => 'required',
            'updateVariantVal' => 'required'
        ]);
        
        $variant->option_name = $request->updateVariant;
        $variant->save();
        
        foreach($request->updateVariantVal as $key=>$updatevalue) {
            // dd($request->idVariantVal[$key]);
            $varval = OptionValues::find($request->idVariantVal[$key]);
            $varval->value_name = $updatevalue;
            $varval->save();
        }
        
        if($request->newVariantVal) {
            $valArray = explode(',', $request->newVariantVal);
            
            //input variant value(s)
            foreach($valArray as $value) {
                $variant_values = new OptionValues;
                $variant_values->value_name = $value;
                $variant_values->option_id = $variant->id;
                $variant_values->save();
            }
        }
        
        return redirect()->route('admin.product-options', ['id' => $variant->product_id]);
    }
    
    public function deleteVariantValue($id)
    {
        $value = OptionValues::find($id)->delete();
        
        return redirect()->back();
    }
    
    public function deleteVariant($id)
    {
        // $product = Products::find($id)->firstOrFail();
        $variant = Options::find($id)->delete();
        // dd($variant);
        
        return redirect()->back();
    }
    
    public function editSKU($id)
    {
        $sku = SKUs::findOrFail($id);
        $skuvalues = SKUvalues::where('sku_id', $sku->id)->get();
        $variants = Options::where('product_id', $sku->product_id)->get();

        // dd($skuvalues);

        return view('admin.productOptions.editsku', compact('sku', 'skuvalues', 'variants'));
    }

    public function updateSKU(Request $request)
    {
        $request->validate([
            'updatePrice' => 'required|numeric',
            'updateStock' => 'required|numeric',
            'updatevarval' => 'required'
        ]);

        // dd($request->inputvarval);

        $sku = SKUs::find($request->id);
        $sku->price = $request->updatePrice;
        $sku->stock = $request->updateStock;
        $sku->save();
        
        foreach($request->updatevarval as $varval) {
            $variant_values = explode('-', $varval);

            $skuval = SKUvalues::updateOrCreate(
                ['sku_id' => $sku->id],
                ['option_id' => $variant_values[0]]
            );
            $skuval->value_id = $variant_values[1];
            $skuval->save();
        }


        return redirect()->route('admin.product-options', ['id' => $sku->product_id]);
    }
}
