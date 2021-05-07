<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function productDetail($id)
    {
        $product = Products::findOrFail($id);
        // $randoms = Products::all()->random(2)->first();
        return view('product-detail', compact('product'));
    }
}
