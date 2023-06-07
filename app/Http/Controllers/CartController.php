<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class CartController extends Controller
{
    //
    public function add(Request $request)
    {
        $product = Product::find($request->product_id);

        $shoppingCart = Cart::name('shopping');

        $shoppingCart->addItem([
            'id'=> $product->id,
            'title' => $product->name,
            'quantity'=> $request->quantity,
            'price'=>$product->price/100
        ]);

       return back();
    }

public function showCart()
{
    $shoppingCart = Cart::name('shopping');
$items= $shoppingCart->getItems();
$total= $shoppingCart->getTotal();

$subTotal= $shoppingCart->getSubTotal();
// dd($items);

    return view('cart.cart',[
        'items'=>$items,
        'total'=>$total,
        'subTotal'=>$subTotal
    ]);

}

public function deleteCart(Request $request)
{
    $hash = $request->itemHash;
    // dd($hash);
    $shoppingCart = Cart::name ('shopping');
    $shoppingCart->removeItem($hash);
    return back();

}

}