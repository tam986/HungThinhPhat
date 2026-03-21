<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaivietController;
use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GiohangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LienHeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SanphamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YeuThichController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/storage-link',function(){
  $targetFolder = storage_path('app/public');
  $linkFolder = public_path('storage');
  symlink($targetFolder, $linkFolder);
});
Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'search')->name('nav.search');
});
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('client.home');
});
Route::get('/check-login', function () {
    return response()->json(['logged_in' => Auth::check()]);
});
Route::controller(YeuThichController::class)->group(function () {
    Route::post('/yeuthich/add', 'add')->name('yeuthich.add');
    Route::post('/yeuthich/remove', 'remove')->name('yeuthich.remove');
    Route::post('/yeuthich/sync', 'syncFavorites')->name('yeuthich.sync');
});
Route::controller(SanphamController::class)->group(function () {
    Route::get('/sanpham', 'index')->name('sanpham.index');
    Route::get('/sanpham/{slug}', 'detail')->name('sanpham.detail');
    Route::get('/sanpham/search', 'search')->name('sanpham.search');
    Route::get('/sanpham/danhmuc/{id}', 'theodanhmuc')->name('sanpham.danhmuc');
    Route::post('/update-view/{id}',  'updateLuotXem')->name('sanpham.updateView');
});
Route::controller(GiohangController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/addCart', 'store')->name('cart.add');
});
Route::controller(UserController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile.profileUser')->middleware('auth.client');
    Route::put('/profile/updated', 'updateProfile')->name('profile.update')->middleware('auth.client');
    Route::get('/profileOrder', 'showOrder')->name('profile.order')->middleware('auth.client');
    Route::patch('/profile/donhang/{id}/cancel',  'cancelOrder')->name('donhang.huy');
    Route::get('/profileFavorites', [YeuThichController::class, 'showProduct'])->name('profile.product');
    Route::get('/profileResetPass',  'showVerifyMail')->name('profile.showVerifyMail')->middleware('auth.client');
    Route::post('/profile/send-reset-otp', [AuthController::class, 'sendResetOtp'])->name('profile.sendResetOtp');
    Route::post('/profile/resend-reset-otp', [AuthController::class, 'resendResetOtp'])->name('profile.resendResetOtp');
    Route::get('/profile/change-password',  'showChangePassVerify')->name('profile.showChangePassVerify');
    Route::put('/profile/submit-reset-password', [AuthController::class, 'submitResetPass'])->name('profile.submitResetPass');
});
Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('/login', 'loginForm')->name('login.form');
    Route::post('/login', 'login')->name('login.submit');
    // Register
    Route::get('/register', 'registerForm')->name('register.form');
    Route::post('/register', 'register');
    Route::get('/verify', 'showVerifyForm')->name('verify.form');
    Route::post('/verify', 'handleVerify');
    Route::post('/verify/resend',  'resendOtp')->name('verify.resend');
    // Logout
    Route::post('/logout', 'logout')->name('logout');
});
Route::controller(BaivietController::class)->group(function () {
    Route::get('/baiviet', 'index')->name('baiviet.index');
    Route::get('/baiviet/search', 'search')->name('baiviet.search');
    Route::get('/baiviet/danhmuc/{id}', 'theoDanhMuc')->name('baiviet.danhmuc');
    Route::get('/baiviet/{slug}', 'show')->name('baiviet.show');
});
Route::get('/lienhe', [LienHeController::class, 'index'])->name('lienhe.form');
Route::post('/lienhe/send', [LienHeController::class, 'send'])->name('lienhe.send');

Route::controller(BinhLuanController::class)->group(function () {
    Route::post('/comments',  'store')->name('comments.store')->middleware('auth.client');
});

// Route::controller(CheckoutController::class)->group(function () {
//     Route::get('/checkout', 'index')->name('checkout.index')->middleware('auth.client');
//     Route::post('/checkout', 'store')->name('checkout.store')->middleware('auth.client');
// });
Route::controller(GiohangController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/addCart', 'store')->name('cart.add');
    Route::put('/cart/update/{id_bienthe}', 'update')->name('cart.update');
    Route::delete('/cart/destroy/{id_bienthe}', 'destroy')->name('cart.destroy');
    Route::post('/cart/apply-coupon', 'applyCoupon')->name('cart.applyCoupon');
    Route::post('/cart/remove-coupon', 'removeCoupon')->name('cart.removeCoupon');
    Route::post('/cart/apply-shipping', 'applyShipping')->name('cart.applyShipping');
});

Route::controller(CheckoutController::class)->group(function () {
    Route::get('/donhang', 'index')->name('donhang.index')->middleware('auth.client');
    Route::get('/checkout', 'index')->name('checkout.index')->middleware('auth.client');
    Route::post('/checkout/process', 'process')->name('checkout.process')->middleware('auth.client');
    Route::get('/checkout/result', 'result')->name('checkout.result')->middleware('auth.client');
    Route::get('/checkout/vnPayCheck', 'vnPayCheck')->name('checkout.vnPayCheck')->middleware('auth.client');
});
Route::post('/binhluan/create', [BinhLuanController::class, 'store'])->name('binhluan.store');