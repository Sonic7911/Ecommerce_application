<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Payment_Gateway;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class CheckoutController extends Controller
{

    public function checkout()
    {
        $shoppingCart = Cart::name('shopping');
        $items= $shoppingCart->getItems();
        $total= $shoppingCart->getTotal();
        
        $subTotal= $shoppingCart->getSubTotal();
        return view('product.checkout',['items'=>$items,
        'total'=>$total,
        'subTotal'=>$subTotal]);
    }

    public function store(Request $request)
    {
        $shoppingCart = Cart::name('shopping');
        $items= $shoppingCart->getItems();
        $total= $shoppingCart->getTotal();

        $data = $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'country'=>'required',
            'province'=>'required',
            'district'=>'required',
            'address'=>'required',
            'payment'=>'required',
            'zip'=>'required'
        ]);

        //create Order

        $address = Address::create([
            'Country'=>$data['country'],
            'Province'=>$data['province'],
            'District'=>$data['district'],
            'Street_Address'=>$data['address'],
            'Zip_Code'=>$data['zip'],
        ]);

        //Create Gateway

        $payment_gateway = Payment_Gateway::where('code',$data['payment'])->first();


        //Create Payment

        $payment = Payment::create([
            'payment_gateway'=>$payment_gateway->id,
            'status'=>"not paid",
            'price_paid'=> 0
        ]);

        //Create Order

        $order = Order::create([
                'tracking_id'=>uniqid('Order-'),
                'total' => $total,
                'name'=>$data['first_name'].' '.$data['last_name'],
                'email'=>$data['email'],
                'phone'=>$data['phone'],
                'billing_id'=> $address->id,
                'shipping_id'=> $address->id,
                'payment_id'=> $payment->id,
                         
                ]
        );

        //Create Order Items

        foreach($items as $item){
        $orderItems = OrderItem::create([
            'order_id'=>$order->id,
            'product_id'=>$item->getId(),
            'name'=>$item->getTitle(),
            'quantity'=>$item->getQuantity(),
            'price'=>$item->getPrice(),
            
        ]);

        //Delete Cart Items
    }
    $shoppingCart->destroy();

    //Redirect to Payment Gateway
    return redirect()->route('payment.show',['paymentGateway'=>$data['payment']])->with(['order_id'=>$order->tracking_id]);
    } //
}
