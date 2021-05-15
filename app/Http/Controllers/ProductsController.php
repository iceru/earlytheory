<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function productDetail($id)
    {
        $product = Products::findOrFail($id);
        $related = Products::where('id', '!=', $id)->take(4)->get();
        return view('product-detail', compact('product', 'related'));
    }
}
