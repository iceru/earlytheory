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

    public function add($id)
    {
        $product = Products::findOrFail($id);

        \Cart::add(array(
            'id' => $id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => 'App\Models\Products'
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
