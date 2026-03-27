<?php

use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\BaivietController;
use App\Http\Controllers\ApiController\BinhLuanController;
use App\Http\Controllers\ApiController\CheckoutController;
use App\Http\Controllers\ApiController\GiohangController;
use App\Http\Controllers\ApiController\HomeController;
use App\Http\Controllers\ApiController\LienHeController;
use App\Http\Controllers\ApiController\OtpController;
use App\Http\Controllers\ApiController\SanphamController;
use App\Http\Controllers\ApiController\UserController;
use App\Http\Controllers\ApiController\YeuThichController;
use App\Http\Controllers\ApiController\CategoryController;
use App\Http\Controllers\ApiController\PartnerController;
use App\Http\Controllers\ApiController\VoucherApiController;
use App\Http\Controllers\ApiController\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/storage-link',function(){
  $targetFolder = storage_path('app/public');
  $linkFolder = public_path('storage');
  symlink($targetFolder, $linkFolder);
});
Route::prefix('api')->group(function() {
    Route::controller(SearchController::class)->group(function () {
        // Route::get('search', 'search')->name('nav.search');
    });
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('client.home');
    });

    // Route::get('check-login', function () {
    //     return response()->json(['logged_in' => Auth::check()]);
    // });

    Route::controller(YeuThichController::class)->group(function () {
        // Route::post('yeuthich/add', 'add')->name('yeuthich.add');
        // Route::post('yeuthich/remove', 'remove')->name('yeuthich.remove');
        // Route::post('yeuthich/sync', 'syncFavorites')->name('yeuthich.sync');
    });

    Route::controller(SanphamController::class)->group(function () {
        Route::get('sanpham', 'index')->name('sanpham.index');
        Route::get('sanpham/latest', 'latest')->name('api.sanpham.latest');
        Route::get('sanpham/sale', 'sale')->name('api.sanpham.sale');
        Route::get('sanpham/{slug}', 'detail')->name('api.sanpham.detail');
        // Route::get('sanpham/search', 'search')->name('sanpham.search');
        // Route::get('sanpham/danhmuc/{id}', 'theodanhmuc')->name('sanpham.danhmuc');
        // Route::post('update-view/{id}',  'updateLuotXem')->name('sanpham.updateView');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('profile', 'index')->name('profile.profileUser')->middleware('auth.client');
        Route::put('profile/updated', 'updateProfile')->name('profile.update')->middleware('auth.client');
        Route::get('profileOrder', 'showOrder')->name('profile.order')->middleware('auth.client');
        Route::patch('profile/donhang/{id}/cancel',  'cancelOrder')->name('donhang.huy');
        Route::get('profileFavorites', [YeuThichController::class, 'showProduct'])->name('profile.product');
        Route::get('profileResetPass',  'showVerifyMail')->name('profile.showVerifyMail')->middleware('auth.client');
        Route::post('profile/send-reset-otp', [AuthController::class, 'sendResetOtp'])->name('profile.sendResetOtp');
        Route::post('profile/resend-reset-otp', [AuthController::class, 'resendResetOtp'])->name('profile.resendResetOtp');
        Route::get('profile/change-password',  'showChangePassVerify')->name('profile.showChangePassVerify');
        Route::put('profile/submit-reset-password', [AuthController::class, 'submitResetPass'])->name('profile.submitResetPass');
    });

    Route::controller(AuthController::class)->group(function () {
        // Route::get('login', 'loginForm')->name('login.form');
        Route::post('login', 'login')->name('login.submit');
        // Route::get('register', 'registerForm')->name('register.form');
        Route::post('register', 'register');
        // Route::get('verify', 'showVerifyForm')->name('verify.form');
        Route::post('verify', 'handleVerify');
        // Route::post('verify/resend',  'resendOtp')->name('verify.resend');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::controller(BaivietController::class)->group(function () {
        Route::get('baiviet', 'index')->name('baiviet.index');
        // Route::get('baiviet/search', 'search')->name('baiviet.search');
        // Route::get('baiviet/danhmuc/{id}', 'theoDanhMuc')->name('baiviet.danhmuc');
        Route::get('baiviet/{slug}', 'show')->name('baiviet.show');
    });

    Route::get('lienhe', [LienHeController::class, 'index'])->name('lienhe.form');
    Route::post('lienhe/send', [LienHeController::class, 'send'])->name('lienhe.send');

    Route::controller(GiohangController::class)->group(function () {
        Route::put('cart/update/{id_bienthe}', 'update')->name('cart.update');
        Route::delete('cart/destroy/{id_bienthe}', 'destroy')->name('cart.destroy');
        Route::post('cart/apply-coupon', 'applyCoupon')->name('cart.applyCoupon');
        Route::post('cart/remove-coupon', 'removeCoupon')->name('cart.removeCoupon');
        Route::post('cart/apply-shipping', 'applyShipping')->name('cart.applyShipping');
        Route::post('cart/validate', 'validateCartStock')->name('cart.validate');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('donhang', 'index')->name('donhang.index');
        Route::get('checkout', 'index')->name('checkout.index');
        Route::post('checkout/process', 'process')->name('checkout.process');
        Route::post('checkout/upload', 'uploadProof')->name('checkout.upload');
        Route::get('checkout/result', 'result')->name('checkout.result');
        Route::get('checkout/vnPayCheck', 'vnPayCheck')->name('checkout.vnPayCheck');
        Route::get('orders/{id}', 'show')->name('order.show');
    });

    // Public API routes for Next.js Client
    Route::match(['get', 'post'], 'navigation-tree', [CategoryController::class, 'tree']);
    Route::match(['get', 'post'], 'categories', [CategoryController::class, 'index']);
    Route::get('partners', [PartnerController::class, 'index']);

    // Posts API
    Route::get('posts', [BaivietController::class, 'index']);

    Route::get('banners', [\App\Http\Controllers\ApiController\BannerController::class, 'getBanners']);
    Route::get('settings', [\App\Http\Controllers\ApiController\SettingController::class, 'getSettings']);
    Route::get('settings/bank', [\App\Http\Controllers\ApiController\SettingController::class, 'getBankSettings']);
    Route::get('vouchers', [VoucherApiController::class, 'index']);
});