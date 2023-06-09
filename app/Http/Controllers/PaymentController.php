<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Http;


class PaymentController extends Controller
{
    public function show($paymentGateway)
    {
        if(!session()->has('order_id')){
            return redirect('home');
        }

        $order = Order::where('tracking_id',session()->get('order_id'))->first();

       if($paymentGateway == 'COD'){
           return view('payment.cod');
    }

    if($paymentGateway == 'Khalti')
    {

        $parameters = [
                'return_url' => route('thankyou'),
                'website_url' => config('app.url'),
                    'amount' => 3000,
                    'purchase_order_id' => $order->tracking_id,
                    'purchase_order_name'=> "ECOMMERCE ORDER". $order->tracking_id,
        ];
       

    $response = Http::withHeaders([
            'Authorization' => 'key '.config('khalti.live_secret_key'),
       ])->post(config('khalti.base_URL').'/epayment/initiate/',$parameters);
       
       if($response->failed()){
           dd('failed');
        }
        $data = $response->json();
        return redirect($data['payment_url']);
       
    }
    }
public function thankyou(Request $request)
{
    $data = $request->all();
    $order = Order::where('tracking_id',$data['purchase_order_id'])->firstOrFail();
    $orderPayment =$order->payment()->update([
        'payment_status'=>'paid',
        'price_paid'=>$data['amount'],
        'transaction_id'=>$data['transaction_id'],
    ]);
    dd($orderPayment);
}
}