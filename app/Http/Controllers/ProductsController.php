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
        $related = Products::where('slug', '!=', $slug)->where('category', 'product')->take(4)->get();
        $product_ids = array();
        $productsSku = Products::all();
        $skus = SKUs::all();
        $skusvalues = SKUvalues::get();
        $optionvalues = OptionValues::get();

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
        return view('product-detail', compact('product', 'related', 'values', 'skus'));
    }

    public function getSku(Request $request) 
    {
        if($request->ajax() && $request->variants == 'variants') {
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

            $skus = SKUs::with('products')->find($sku_id);

            if(!$skus) {
                return response()->json(['message' => 'Tidak ada item untuk produk tersebut'], 404);
            } else if ($skus->stock <= 0 && $skus->products->category == 'product') {
                return response()->json(['message' => 'Stok habis untuk item yang dipilih'], 404);
            }

            $object = json_decode($skus);
            $object->values = $values_name;

            return response()->json($object);
        } else {
            $skus = SKUs::where('product_id', $request->id)->first();
            return response()->json($skus);
        }
    }
}
