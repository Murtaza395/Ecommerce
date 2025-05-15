<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
public function home(){
    $product=Product::all();
    if(Auth::user()){
    $user= Auth::user();
    $userid=$user->id;
    $count=Cart::where('user_id',$userid)->count();
    }
    else{
        $count=" ";
    }
    return view('home.index',[

        'product'=> $product,
        'count'=> $count
    ]);
}
public function login_home(){
    $product=Product::all();
    $user= Auth::user();
    $userid=$user->id;
    $count=Cart::where('user_id',$userid)->count();
    return view('home.index',[

        'product'=> $product,
        'count'=> $count
    ]);
}
public function product_details($id){
    $detail=Product::findorFail($id);
    $user= Auth::user();
    $userid=$user->id;
    $count=Cart::where('user_id',$userid)->count();
    return view('home.product_details',[
        'detail'=> $detail,
        'count'=> $count
    ]);
}
public function addCart($id){
    if (!Gate::allows('place-order')) {
        abort(403, 'Unauthorized action.');
    }
    $product_id= $id;;
    $user_id =Auth::user()->id;
    $data= new cart();
    $data->user_id=$user_id;
    $data->product_id=$product_id;
    $data->save();
    return redirect()->back()->with('success','product added to cart successfully');
}
    public function myCart(){
        if (!Gate::allows('view-cart')) {
            abort(403, 'Unauthorized action.');
        }
        if(Auth::check()){
        $user= Auth::user();
        $userid=$user->id;
        $count=Cart::where('user_id',$userid)->count();
        $cart = Cart::where('user_id',$userid)->get();
        }
        return view('home.mycart',[
            'count'=> $count,
            'cart'=>$cart
        ]);
    }
    public function removeCart($id){
        $cart = Cart::findorFail($id);
        $cart->delete();
        return redirect()->back()->with('success','cart removed successfully');
    }
    public function placeOrder(Request $request)
    {
        if (!Gate::allows('place-order')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'address'=>'required|min:3',
            'phone'=>'required|min:8'
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $userid=Auth::user()->id;
        $cart = Cart::where('user_id',$userid)->get();
        foreach($cart as $carts){
        $order = new Order();
        $order->name=$request->name;
        $order->rec_address=$request->address;
        $order->phone=$request->phone;
        $order->user_id=$userid;
        $order->product_id=$carts->product_id;
        $order->save();
        }
        $cart_remove=Cart::where('user_id',$userid)->get();
        foreach($cart_remove as $cart){
            $data=Cart::find($cart->id);
            $data->delete();
        }
        return redirect()->route('dashboard')->with('success','order placed successfully');
    }
    public function myOrder(){
        if (!Gate::allows('view-orders')) {
            abort(403, 'Unauthorized action.');
        }
        $user =Auth::user()->id;
        $count=Cart::where('user_id',$user)->count();
        $order=Order::where('user_id',$user)->paginate(2);
        return view('home.order',[
            'count'=> $count,
            'order'=> $order,
        ]);
    }
     public function myProfile($id){
       User::findorFail($id);
       $count=Cart::where('user_id', $id)->count();
       return view('home.profile',[
        'count'=> $count,
       ]);
    }
    public function editProfile($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'phone'=>'required|numeric',
            'address'=>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $edit = User::findOrFail($id);
        $edit->name=$request->name;
        $edit->phone=$request->phone;
        $edit->address=$request->address;
        $edit->save();
        return redirect()->back()->with('success','Profile edited successfully');
    }
    public function resetPassword($id,Request $request){
        $validator = Validator::make($request->all(),[
            'current_password'=>'required',
            'new_password'=>'required',
            'password_confirmation'=>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user= User::findOrFail($id);
        if(Hash::make($request->password==$user->password && $request->new_password==$request->password_confirmation)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            Auth::logout();
            return redirect()->back()->with('success', 'Password updated successfully.'); 
        }
        else{
            return redirect()->back();
        }
 
        }
        public function changePass($id){
            User::findOrFail($id);
            $count=Cart::where('user_id',Auth::user()->id)->count();
            return view('home.reset',[
                'count'=>$count,
            ]);
        }
       
    }