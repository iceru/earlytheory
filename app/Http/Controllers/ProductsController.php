<?php

namespace App\Http\Controllers;

use App\Models\SKUs;
use App\Models\Options;
use App\Models\Products;
use App\Models\SKUvalues;
use App\Models\OptionValues;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function productDetail($slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
        $related = Products::where('slug', '!=', $slug)->where('category', 'service')->take(4)->get();
        $options = Options::where('product_id', $product->id)->pluck('id', 'option_name');

        $values = collect();
        foreach ($options as $key => $option) {
            $optionsValues = OptionValues::where('option_id', $option)->get();
            $optionsValues->put('option', $key);
            $values->push($optionsValues);
        }
        // dd($skusvalues);
        if($product->category == 'product') {
            $related = Products::where('slug', '!=', $slug)->where('category', 'product')->take(4)->get();
        }
        return view('product-detail', compact('product', 'related', 'values'));
    }

    public function getSku(Request $request) 
    {
        if($request->ajax()) {
            $option_values = $request->option_values;
            $skusvalues = SKUvalues::get();
            $skus_selected = array();
            $values_name = array();

            foreach ($skusvalues as $key => $value) {
                foreach ($option_values as $key => $item) {
                    if($item["option"] == $value->option_id && $item["value"] == $value->value_id) {
                        array_push($skus_selected, $value->sku_id);
                        $value_datas = OptionValues::where('id', $value->value_id)->pluck('value_name');
                        $value_name = $value_datas->implode('', 'value_name');
                        array_push($values_name, $value_name);
                    }
                }
            }

            $values_name = array_unique($values_name);
            $values_name = implode(", ", $values_name);

            $unique = array_unique( array_diff_assoc( $skus_selected, array_unique( $skus_selected )));
            $sku_id = (int) implode("", $unique);

            $skus = SKUs::findOrFail($sku_id);
            
            if($skus->stock <= 0) {
                return response()->json($skus, 404);
            }

            $object = json_decode($skus);
            $object->values = $values_name;

            return response()->json($object);
        }
    }
}
