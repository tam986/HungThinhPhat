<?php

namespace App\Http\Controllers;

use App\Models\Baiviet;
use App\Models\Bienthe;
use App\Models\Danhmuc;
use App\Models\Magiamgia;
use App\Models\Sanpham;
use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $danhmucs = Danhmuc::orderBy('tendanhmuc', 'asc')->get();
        $voucher = Magiamgia::where('trangthai', 0)->get();
        $products = Bienthe::with('sanpham')->orderBy('created_at', 'desc')->limit(8)->get();
        $productView = Bienthe::select('bienthe.*')
            ->join('sanphams', 'bienthe.id_sp', '=', 'sanphams.id')
            ->orderBy('sanphams.luotxem', 'desc')
            ->with('sanpham')
            ->paginate(4);
        $productDiscount = Bienthe::with('sanpham')->orderBy('giakm', 'desc')->paginate(4);
        $baivietNoiBat = Baiviet::orderBy('luotxem', 'desc')->limit(6)->get();
        return view('Home', compact('danhmucs', 'voucher', 'products', 'productView', 'productDiscount', 'baivietNoiBat'));
    }
    public function footer()
    {
        $danhmucAll = Danhmuc::orderBy('tendanhmuc', 'asc')->get();
        $danhmucBv = DanhMucBaiViet::orderBy('tendm', 'asc')->get();
         return view('layouts.footer', compact('danhmucAll','danhmucBv'));
    }
}
