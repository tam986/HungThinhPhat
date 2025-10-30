<?php

use App\Http\Controllers\AdminDMController;
use App\Http\Controllers\AdminSPController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminThongKeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaivietController;
use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\DanhMucBaiVietController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\KhoiLuongController;
use App\Http\Controllers\MaGiamGiaController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\NhanBanhController;
use Illuminate\Support\Facades\Route;

Route::get('/storage-link',function(){
  $targetFolder = storage_path('app/public');
  $linkFolder = public_path('storage');
  symlink($targetFolder, $linkFolder);
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login.show');
    Route::post('/login', 'loginActive')->name('login.active');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware(['auth.admin'])->group(function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard.home');
    Route::controller(DashBoardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.index');
        Route::get('/dashboard/filter', 'filter')->name('dashboard.filter');
    });
    
    //User
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/user', 'index')->name('user.index');
        Route::get('/user/detail/{id}', 'show')->name('user.detail');
        Route::get('/profile/{id}', 'profileUser')->name('profile.profileUser');
        Route::get('/user/create', 'create')->name('user.create');
        Route::post('/user/created', 'store')->name('user.store');
        Route::get('/user/{id}/edit', 'edit')->name('user.edit');
        Route::put('/user/{id}', 'update')->name('user.update');
        Route::put('/user/updateRole/{id}', 'updateRole')->name('user.updateRole');
        Route::delete('/user/{id}', 'destroy')->name('user.destroy');
        Route::post('/user/{id}/restore', 'restore')->name('user.restore');
    });
    
    //Bài viết
    Route::controller(BaivietController::class)->group(function () {
        Route::get('/baiviet', 'index')->name('baiviet.index');
        Route::get('/baiviet/active/{id}', 'active')->name('baiviet.active');
        Route::get('/baiviet/unactive/{id}', 'unactive')->name('baiviet.unactive');
        Route::get('/baiviet/create', 'create')->name('baiviet.create');
        Route::post('/ckeditor/upload', 'upload')->name('ckeditor.upload');
        Route::get('/baiviet/trash', 'trashed')->name('baiviet.trashed');
        Route::post('/baiviet/store', 'store')->name('baiviet.store');
        Route::get('/baiviet/{id}', 'show')->name('baiviet.show');
        Route::get('/baiviet/{id}/edit', 'edit')->name('baiviet.edit');
        Route::put('/baiviet/{id}', 'update')->name('baiviet.update');
        Route::delete('/baiviet/{id}/force-delete', 'forceDelete')->name('baiviet.delete');
        Route::delete('/baiviet/{id}/soft-delete', 'softDelete')->name('baiviet.softDelete');
        Route::post('/restore/{id}', 'restore')->name('baiviet.restore');
        Route::post('/upload', 'upload');
    });
    Route::controller(DanhMucBaiVietController::class)->group(function () {
        Route::get('/dmBaiViet',  'index')->name('danhmuc.index');
        Route::get('/dmBaiViet/create',  'create')->name('danhmuc.create');
        Route::post('/dmBaiViet/created',  'store')->name('danhmuc.store');
        Route::get('/dmBaiViet/{id}/edit', 'edit')->name('danhmuc.edit');
        Route::put('/dmBaiViet/{id}',  'update')->name('danhmuc.update');
        Route::delete('/dmBaiViet/{id}',  'destroy')->name('danhmuc.destroy');
    });
    Route::controller(BinhLuanController::class)->group(function () {
        Route::get('/binhluan', 'index')->name('binhluans.index');
        Route::post('/binhluan/{id}/duyet',  'duyet')->name('binhluan.duyet');
        Route::put('/binhluan/{id}/tuchoi',  'an')->name('binhluan.an');
        Route::put('/binhluan/{id}/unactive', 'unactive')->name('binhluan.unactive');
        Route::put('/binhluan/{id}/active', 'active')->name('binhluan.active');
    });
    
    //Sản phẩm
    Route::controller(AdminSPController::class)->group(function () {
        Route::get('/sanpham', 'index')->name('sanpham.index');
        Route::post('/sanpham/bienthe', [AdminSPController::class, 'getBienthe']);
        Route::get('/sanpham/khoiluong-nhanbanh/{id_sp}', [AdminSPController::class, 'getKhoiluongNhanbanh']);
        Route::get('/sanpham/create', 'create')->name('sanpham.create');
        Route::post('/sanpham', 'store')->name('sanpham.store');
        Route::get('/sanpham/{id}/edit', 'edit')->name('sanpham.edit');
        Route::put('/sanpham/{id}', 'update')->name('sanpham.update');
        Route::get('/sanpham/{id}/detail', 'detail')->name('sanpham.detail');
        Route::put('/sanpham/{id}/status', 'updateStatus')->name('sanpham.updateStatus');
        Route::delete('/sanpham/{id}', 'softDelete')->name('sanpham.softDelete');
        Route::get('/sanpham/trashed', 'trashed')->name('sanpham.trashed');
        Route::post('/sanpham/restore/{id}', 'restore')->name('sanpham.restore');
        Route::delete('/sanpham/destroy/{id}', 'destroy')->name('sanpham.destroy');
    });
    Route::controller(AdminDMController::class)->group(function () {
        Route::get('/danhmuc', 'index')->name('danhmucDM.index');
        Route::get('/danhmuc/active/{id}', 'active')->name('danhmucDM.active');
        Route::get('/danhmuc/unactive/{id}', 'unactive')->name('danhmucDM.unactive');
        Route::post('/danhmuc/checkthutu', 'checkthutu')->name('danhmucDM.checkthutu');
        Route::get('/danhmuc/create', 'create')->name('danhmucDM.create');
        Route::post('/danhmuc/store', 'store')->name('danhmucDM.store');
        Route::get('/danhmuc/{id}/detail', 'detail')->name('danhmucDM.detail');
        Route::get('/danhmuc/{id}/edit', 'edit')->name('danhmucDM.edit');
        Route::put('/danhmuc/{id}', 'update')->name('danhmucDM.update');
        Route::delete('/danhmuc/{id}', 'destroy')->name('danhmucDM.destroy');
    });
    Route::controller(NhaCungCapController::class)->group(function () {
        Route::get('/nhacungcap', 'index')->name('nhacungcap.index');
        Route::get('/nhacungcap/active/{id}', 'active')->name('nhacungcap.active');
        Route::get('/nhacungcap/unactive/{id}', 'unactive')->name('nhacungcap.unactive');
        Route::post('/nhacungcap/checkthutu', 'checkthutu')->name('nhacungcap.checkthutu');
        Route::get('/nhacungcap/create', 'create')->name('nhacungcap.create');
        Route::post('/nhacungcap/store', 'store')->name('nhacungcap.store');
        Route::get('/nhacungcap/{id}/detail', 'detail')->name('nhacungcap.detail');
        Route::get('/nhacungcap/{id}/edit', 'edit')->name('nhacungcap.edit');
        Route::put('/nhacungcap/{id}', 'update')->name('nhacungcap.update');
        Route::delete('/nhacungcap/{id}', 'destroy')->name('nhacungcap.destroy');
    });
    Route::controller(KhoiLuongController::class)->group(function () {
        Route::get('/khoiluong',  'index')->name('khoiluong.index');
        Route::get('/khoiluong/create',  'create')->name('khoiluong.create');
        Route::post('/khoiluong/created',  'store')->name('khoiluong.store');
        Route::get('/khoiluong/{id}/edit', 'edit')->name('khoiluong.edit');
        Route::put('/khoiluong/{id}',  'update')->name('khoiluong.update');
        Route::delete('/khoiluong/{id}',  'destroy')->name('khoiluong.destroy');
    });
    Route::controller(NhanBanhController::class)->group(function () {
        Route::get('/nhanbanh',  'index')->name('nhanbanh.index');
        Route::get('/nhanbanh/create',  'create')->name('nhanbanh.create');
        Route::post('/nhanbanh/created',  'store')->name('nhanbanh.store');
        Route::get('/nhanbanh/{id}/edit', 'edit')->name('nhanbanh.edit');
        Route::put('/nhanbanh/{id}',  'update')->name('nhanbanh.update');
        Route::delete('/nhanbanh/{id}',  'destroy')->name('nhanbanh.destroy');
    });
    
    //Đơn hàng
    Route::controller(DonHangController::class)->group(function () {
        Route::get('/donhang', 'index')->name('donhang.index');
        Route::get('/donhang/filter', '')->name('donhang.date');
        Route::get('/donhang/show/{id}', 'show')->name('donhang.show');
        Route::get('/donhang/create', 'create')->name('donhang.create');
        Route::post('/donhang/created',  'store')->name('donhang.store');
        Route::get('/donhang/detail', 'show')->name('donhang.detail');
        Route::get('/donhang/{id}/edit', 'edit')->name('donhang.edit');
        Route::put('/donhang/{id}',  'update')->name('donhang.update');
        Route::put('/donhang/updateTT/{id}',  'updateTT')->name('donhang.updateTT');
        Route::put('/donhang/{id}/status',  'updateStatus')->name('donhang.updateStatus');
        Route::delete('/donhang/{id}',  'destroy')->name('donhang.destroy');
        Route::get('/get-chart-data', 'getChartData')->name('donhang.getChartData');
    });
    Route::controller(MaGiamGiaController::class)->group(function () {
        Route::get('/magiamgia', 'index')->name('magiamgia.index');
        Route::get('/magiamgia/create', 'create')->name('magiamgia.create');
        Route::post('/magiamgia/store', 'store')->name('magiamgia.store');
        Route::get('/magiamgia/active/{id}', 'active')->name('magiamgia.active');
        Route::get('/magiamgia/unactive/{id}', 'unactive')->name('magiamgia.unactive');
        Route::get('/magiamgia/{id}/edit', 'edit')->name('magiamgia.edit');
        Route::put('/{id}', 'update')->name('magiamgia.update');
        Route::delete('/{id}', 'destroy')->name('magiamgia.destroy');
    });

    Route::get('/api/sanpham/{id}/bienthe', function ($id) {
        return \App\Models\BienThe::where('id_sp', $id)
            ->with('khoiluong', 'nhanbanh')
            ->get();
    });
    Route::controller(AdminThongKeController::class)->group(function () {
        Route::get('/thongke', 'index')->name('thongke.index');
    });
});
