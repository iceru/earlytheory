<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function productDetail($slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
        $related = Products::where('slug', '!=', $slug)->take(4)->get();
        return view('product-detail', compact('product', 'related'));
    }
}
