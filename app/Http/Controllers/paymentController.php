<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;

class paymentController extends Controller
{
     public function stripe($value)
    {
        return view('home.stripe',[
            'value'=> $value
        ]);
    }
    public function stripePost(Request $request,$value)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $value * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment" 
        ]);
        $userid=Auth::user()->id;
        $cart = Cart::where('user_id',$userid)->get();
        $name=Auth::user()->name;
        $phone=Auth::user()->phone;
        $address=Auth::user()->address;
        foreach($cart as $carts){
        $order = new Order();
        $order->name=$name;
        $order->rec_address=$address;
        $order->phone=$phone;
        $order->user_id=$userid;
        $order->product_id=$carts->product_id;
        $order->payment_status='paid';
        $order->save();
        }
        $cart_remove=Cart::where('user_id',$userid)->get();
        foreach($cart_remove as $cart){
            $data=Cart::find($cart->id);
            $data->delete();
        }
        return redirect()->route('dashboard')->with('success','order placed successfully');
    }
}
