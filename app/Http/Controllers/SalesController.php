<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function checkout()
    {
        if(!\Cart::isEmpty()) {
            $cart = \Cart::getContent();
            // foreach ($cart as $item) {
            //     dd($item->id);
            // }
    
            $salesNo = time();
            $total = \Cart::getTotal();
    
            $sales = new Sales;
            $sales->sales_no = $salesNo;
            $sales->total_price = $total;
            $sales->email = ' ';
            $sales->save();
    
            foreach (\Cart::getContent() as $item) {
                $product = Products::find($item->id);
                $product->sales()->attach($sales, ['question' => ' '], ['qty' => $item->qty]);
            }
    
            \Cart::clear();
            return redirect()->route('sales.detail', ['id' => $sales->id]);
        }
        else {
            return redirect('/cart');
        }
    }

    public function detail($id)
    {
        $sales = Sales::find($id);

        return view('checkout.detail', compact('sales'));
    }
}
