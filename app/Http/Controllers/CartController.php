<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $userID = Auth::id();
        $items = \Cart::session($userID)->getContent();
        $total = \Cart::session($userID)->getTotal();
        // dd($items);
        return view('cart', compact('items', 'total'));
    }

    public function add($id)
    {
        $product = Products::findOrFail($id);
        $userID = Auth::id();

        \Cart::session($userID)->add(array(
            'id' => $id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => 'App\Models\Products'
        ));

        return redirect('/cart');
    }

    public function min($id)
    {
        $userID = Auth::id();
        \Cart::session($userID)->update($id, array(
            'quantity' => -1
        ));

        return redirect('/cart');
    }

    public function remove($id)
    {
        $userID = Auth::id();
        \Cart::session($userID)->remove($id);

        return redirect('/cart');
    }

    public function plus($id)
    {
        $userID = Auth::id();
        \Cart::session($userID)->update($id, array(
            'quantity' => 1
        ));

        return redirect('/cart');
    }

    public function clear()
    {
        $userID = Auth::id();
        \Cart::session($userID)->clear();

        return redirect('/cart');
    }
}
