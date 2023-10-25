<?php

namespace App\Http\Controllers;

use App\Models\SKUs;
use App\Models\Course;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $items = \Cart::getContent();
        $ramalan = array();
        $courses = array();
        $workshops = array();
        foreach($items as $item) {
            if($item->attributes->type === 'course'){
                array_push($courses, $item);
            } else {
                array_push($ramalan, $item);
            }
        }

        foreach($courses as $course) {
            array_push($workshops, $course->associatedModel->workshop);
        }
        $workshops = array_unique($workshops);

        $total = \Cart::getTotal();

        return view('cart', compact('items', 'ramalan', 'workshops', 'courses', 'total'));
    }

    public function add($id, Request $request)
    {
        $product = Products::findOrFail($id);
        $price = (int) $request->price;
        $stock = (int) $request->stock;
        $product_price = $product->price;
        if($price > 0 || $price) {
            $product_price = $price;
        }
        $sku = (int) $request->sku;
        $values = $request->values;
        $product_id = $id;
        if($sku > 0) {
            $id = 'sku-'.$sku;
        }
        
        \Cart::add(array(
            'id' => $id,
            'name' => $product->title,
            'price' => $product_price,
            'quantity' => 1,
            'attributes' => array(
                'product_id' => $product_id,
                'sku_id' => $sku,
                'values' => $values,
                'stock' => $stock,
            ),
            'associatedModel' => $product
        ));


        $ctc = \Cart::getContent()->count();
        return \Response::json(['success' => 'Produk sukses ditambahkan ke keranjang', 'count' => $ctc]);
    }

    public function addCourse($id)
    {
        $course = Course::findOrFail($id);

        \Cart::add(array(
            'id' => $id,
            'name' => $course->title,
            'price' => (int) $course->price,
            'quantity' => 1,
            'attributes' => array (
                'type' => 'course'
            ),
            'associatedModel' => $course
        ));
        
        $ctc = \Cart::getContent()->count();
        return \Response::json(['success' => 'Produk sukses ditambahkan ke keranjang', 'count' => $ctc]);
    }

    public function min($id)
    {
        \Cart::update($id, array(
            'quantity' => -1
        ));

        return redirect('/cart');
    }

    public function remove($id)
    {
        \Cart::remove($id);

        return redirect('/cart');
    }

    public function plus($id)
    {
        \Cart::update($id, array(
            'quantity' => 1
        ));

        return redirect('/cart');
    }

    public function clear()
    {
        \Cart::clear();

        return redirect('/cart');
    }
}
