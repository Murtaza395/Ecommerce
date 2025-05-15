<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Mail\sendOtpmail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $remember = $request->has('remember');
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember )){
            if(Auth::user()->role==="admin"){
                return redirect()->route('admin.dashboard')->with('success','you logged in successfully');
            }
            return redirect()->route('home')->with('success','you logged in successfully');
        }else{
            return redirect()->back()->with('error','Invalid Credentials');
        }
    }
    public function register(){
        return view('register');
    }
       public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'f_name'=>'required|min:3',
            'l_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        if($validator->passes()){
        $user_data= new User();
            $user_data->name=$request->f_name .' '. $request->l_name; 
            $user_data->email=$request->email;
            $user_data->password=$request->password;
            $user_data->save();
            return redirect()->route('login')->with('success','you registered successfully');
    }else{
        return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    }
    public function codeVerify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate->errors());
        }

        $email = Session::get("email_{$request->otp}");
        // dd($email);
        if (!$email) {
            return redirect()->back()->with('error', 'Session expired. Request a new OTP.');
        }
    
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
    
        // Check OTP and expiry
        if ($user->otp !== $request->otp) {
            return redirect()->back()->with('error', 'Incorrect OTP.');
        }
    
        if (now()->greaterThan($user->otp_expiry)) {
            return redirect()->back()->with('error', 'OTP expired. Request a new one.');
        }
    
        // Update user verification status
        $user->email_verified = 1;
        $user->otp = ''; // Clearing OTP
        $user->otp_expiry = null; // Clearing OTP expiry
        $user->save();
    
        // Clear session data
        Session::forget(["email_{$request->otp}"]);
    
        return redirect()->route('home')->with('success', 'OTP verified successfully!');
    }
    public function EmailVer(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>'required|email',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $user = User::where('email',$request->email)->exists();
        if(!$user){
            return redirect()->back()->with('error','This email is not registered');
        }
        $users = User::where('email',$request->email)->first();
        $otp=  rand(100000,999999);
        $users->otp=$otp;
        $users->otp_expiry=now()->addMinutes(10);
        $users->save();
        Mail::to($request->email)->send(new sendOtpmail($request->email,$otp));
        return redirect()->route('verEmail');
    }
    
    public function codeVerifyForget(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);
    
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate->errors());
        }
    
        // Find user by OTP
        $user = User::where('otp', $request->otp)->first();
    
        // Ensure user exists before accessing OTP
        if (!$user) {
            return redirect()->back()->with('error', 'Invalid OTP or user not found.');
        }
    
        // Check if OTP is expired
        if (!$user->otp_expiry || now()->greaterThan($user->otp_expiry)) {
            return redirect()->back()->with('error', 'OTP expired or invalid.');
        }
    
        // If OTP is valid, generate password reset token
        $token = Str::random(60);
    
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );
    
        Mail::to($user->email)->send(new ResetPasswordMail($token,$user->email));
    
        $user->update(['otp' => null, 'otp_expiry' => null]);
    
        return redirect()->route('login')->with('success', 'Password reset link sent successfully.');
    }
    public function otpVerfication(){
        return view('Verification');
    }
    
    public function resetPassword(Request $request)
{
    $validate = Validator::make($request->all(), [
        'token' => 'required',
        'password' => 'required|min:6|confirmed',
        'password_confirmation'=>'required|min:6',
        'email' => 'required',
    ]);
    if ($validate->fails()) {
        dd($validate->errors());
        return redirect()->back()->withInput()->withErrors($validate->errors());
    }


    // Get reset record from database
    // dd($request->email);
    $resetRecord = DB::table('password_resets')
    ->where('email', $request->email)
    ->where('created_at', '>=', now()->subMinutes(30))
    ->first();
    // dd($resetRecord);
    if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
        return redirect()->route('login')->with('error', 'Invalid or expired token.');
    }

    // Find the user by email
    $user = User::where('email', $resetRecord->email)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'User not found.');
    }

    // Update password
    $user->password=Hash::make($request->password);
    $user->save();

    // Delete token after reset
    DB::table('password_resets')->where('email', $user->email)->delete();

    return redirect()->route('login')->with('success', 'Password reset successfully!');
}

    public function checkEmail(Request $request) {
        $email = $request->email;
    
        // Validate email format first
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email format',
            ], 400);
        }
    
        // Check if email exists in the database
        $exists = User::where('email', $email)->exists();
        
        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'This email already exists',
            ], 200);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'This email is valid and available',
        ], 200);
    }
        public function logout(){
            if(Auth::check()){
            Auth::logout();
            return redirect()->route('login')->with('success','you logged out successfully');
            }
        }
        public function verEmail(){
            return view('VerificationEmail');
        }
        public function EmailPageVerify(){
            return view('EmailPageVerify');
        }
}
