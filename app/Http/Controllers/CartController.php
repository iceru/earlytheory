<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $items = \Cart::getContent();
        $total = \Cart::getTotal();

        return view('cart', compact('items', 'total'));
    }

    public function add($id, Request $request)
    {
        $product = Products::findOrFail($id);
        $price = (int) $request->price;
        $product_price = $product->price;
        if($price > 0 || $price) {
            $product_price = $price;
        }
        $sku = (int) $request->sku;
        $values = $request->values;
        $product_id = $id;
        if($sku) {
            $id = 'sku-'.$sku;
        }

        
        \Cart::add(array(
            'id' => $id,
            'name' => $product->title,
            'price' => $product_price,
            'quantity' => 1,
            'attributes' => array(
                'product_id' => $product_id,
                'values' => $values,
            ),
            'associatedModel' => $product
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
