<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function productDetail($slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
<<<<<<< HEAD
        $related = Products::where('slug', '!=', $slug)->take(4)->get();
=======
        $related = Products::where('slug', '!=', $slug)->where('category', 'service')->take(4)->get();

        if($product->category == 'product') {
            $related = Products::where('slug', '!=', $slug)->where('category', 'product')->take(4)->get();
        }
>>>>>>> 9b1c29099e6cd54c0874a3d75fd3036f272c4875
        return view('product-detail', compact('product', 'related'));
    }
}
