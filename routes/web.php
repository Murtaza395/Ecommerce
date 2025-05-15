<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\paymentController;
use Illuminate\Support\Facades\Route;


Route::get("/", [HomeController::class,"home"])->name("home");
Route::middleware(['auth'])->group(function(){
    Route::controller(HomeController::class)->group(function(){
Route::get("/dashboard", "login_home")->name("dashboard");
Route::get("/dashboard/productdetails/{id}", [HomeController::class,"product_details"])->name("productDetails");
Route::get("add_cart/{id}", "addCart")->name("addCart");
Route::get("mycart", "myCart")->name("myCart");
Route::delete("mycart/deletecart/{id}", "removeCart")->name("removeCart");
Route::post("mycart/order", "placeOrder")->name("placeOrder");
Route::get("myorder", "myOrder")->name("myOrders");
Route::get("/dashboard/Profile/{id}", "myProfile")->name("myProfile");
Route::put("/dashboard/editProfile/{id}", "editProfile")->name("editProfile");
Route::get("/dashboard/resetPassword/{id}", "changePass")->name("changePass");
Route::put("/dashboard/resetPassword/{id}", "resetPassword")->name("resetPassword");
    });
});

Route::get("stripe/{value}", [paymentController::class,"stripe"])->name("stripe");
Route::post("stripe/{value}", [paymentController::class,"stripePost"])->name("stripe.post");



Route::middleware(['auth','admin'])->group(function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('admin/dashboard','index')->name('admin.dashboard');
Route::get('admin/category','View_category')->name('view.category');
Route::post('admin/addcategory','add_category')->name('addCategory');
Route::get('admin/editcategory/{id}','edit')->name('admin.editCategory');
Route::put('admin/editcategory/{id}','update')->name('admin.updateCategory');
Route::delete('admin/deletecategory/{id}','delete')->name('deleteCategory');
Route::get('admin/addproduct','add_product')->name('addProduct');
Route::post('admin/uploadproduct','upload_product')->name('upload_product');
Route::get('admin/viewproduct','showProducts')->name('showProduct');
Route::get('admin/editproduct/{id}','editProducts')->name('editProduct');
Route::put('admin/updateproduct/{id}','updateProducts')->name('updateProduct');
Route::delete('admin/deleteproduct/{id}','destroyProducts')->name('deleteProduct');
Route::get('admin/vieworder','viewOrders')->name('viewOrders');
Route::get('admin/ontTheWay/{id}','ontTheWay')->name('ontTheWay');
Route::get('admin/delivered/{id}','delivered')->name('delivered');
Route::get('admin/printpdf/{id}','printPDF')->name('printPDF');
Route::get('admin/viewUsers','viewUsers')->name('viewUsers');
Route::delete('admin/viewUsers/{id}','deleteUsers')->name('deleteUser');
Route::get('admin/resetPassword/{id}','changePasss')->name('changePasss');
Route::put("admin/resetPassword/{id}", "resetPasswords")->name("resetPasswords");
});
});


Route::get('/VerfyEmail', [AuthController::class, 'verEmail'])->name('verEmail')->middleware('checkUser');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/authenticate',[AuthController::class,'store'])->name('store');
Route::get('/emailPage', [AuthController::class, 'EmailPageVerify'])->name('emailPage')->middleware('checkUser');;
Route::post('/EmailVerify',[AuthController::class,'EmailVer'])->name('emailVer')->middleware('checkUser');
Route::get('/verifyOtp',[AuthController::class,'otpVerfication'])->name('otpVerfication')->middleware('checkUser');
    Route::post('/verfiyOtp',[AuthController::class,'codeVerify'])->name('codeVerify')->middleware('checkUser');
Route::get('/login',function(){
    return view('login');
})->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/updatePassword/{token}',function(){
    return view('Updatepassword');
})->name('updatePassword');
Route::post('/password/update', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/password/reset', [AuthController::class, 'codeVerifyForget'])->name('password.verify');
Route::get('/checkEmail',[AuthController::class,'checkEmail'])->name('email.check');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

