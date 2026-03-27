<?php

use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\BaivietController;
use App\Http\Controllers\ApiController\CheckoutController;
use App\Http\Controllers\ApiController\GiohangController;
use App\Http\Controllers\ApiController\HomeController;
use App\Http\Controllers\ApiController\LienHeController;
use App\Http\Controllers\ApiController\SanphamController;
use App\Http\Controllers\ApiController\UserController;
use App\Http\Controllers\ApiController\YeuThichController;
use App\Http\Controllers\ApiController\CategoryController;
use App\Http\Controllers\ApiController\PartnerController;
use App\Http\Controllers\ApiController\VoucherApiController;
use App\Http\Controllers\ApiController\SearchController;
use Illuminate\Support\Facades\Route;

// Public API routes for Next.js Client
Route::match(['get', 'post'], 'navigation-tree', [CategoryController::class, 'tree']);
Route::match(['get', 'post'], 'categories', [CategoryController::class, 'index']);
Route::get('partners', [PartnerController::class, 'index']);
Route::get('sanpham', [SanphamController::class, 'index']);
Route::get('sanpham/latest', [SanphamController::class, 'latest']);
Route::get('sanpham/sale', [SanphamController::class, 'sale']);
Route::get('sanpham/{slug}', [SanphamController::class, 'detail']);
Route::get('baiviet', [BaivietController::class, 'index']);
Route::get('baiviet/{slug}', [BaivietController::class, 'show']);
Route::get('banners', [\App\Http\Controllers\ApiController\BannerController::class, 'getBanners']);
Route::get('settings', [\App\Http\Controllers\ApiController\SettingController::class, 'getSettings']);
Route::get('settings/bank', [\App\Http\Controllers\ApiController\SettingController::class, 'getBankSettings']);
Route::get('vouchers', [VoucherApiController::class, 'index']);
Route::post('checkout/process', [CheckoutController::class, 'process']);
Route::post('checkout/upload', [CheckoutController::class, 'uploadProof']);
Route::get('orders/{id}', [CheckoutController::class, 'show']);
Route::post('cart/validate', [GiohangController::class, 'validateCartStock']);
