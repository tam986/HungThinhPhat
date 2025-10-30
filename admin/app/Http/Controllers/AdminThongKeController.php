<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanpham;
use App\Models\BienThe;
use App\Models\DanhMucBaiViet;
use App\Models\Donhang;
use App\Models\DonHangChiTiet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminThongKeController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to  = $request->input('to');

        $topTonKhoNhieu = BienThe::with('sanpham')
        ->select('id_sp', DB::raw('SUM(soluong) as tong_ton'))
        ->groupBy('id_sp')
        ->orderByDesc('tong_ton')
        ->take(5)
        ->get()
        ->map(fn($bienThe) => [
            'tensp'    => $bienThe->sanpham->tensp,
            'tong_ton' => $bienThe->tong_ton,
        ]);
    
        $topTonKhoIt = BienThe::with('sanpham')
            ->select('id_sp', DB::raw('SUM(soluong) as tong_ton'))
            ->groupBy('id_sp')
            ->orderBy('tong_ton', 'asc')
            ->take(5)
            ->get()
            ->map(fn($bienThe) => [
                'tensp'    => $bienThe->sanpham->tensp,
                'tong_ton' => $bienThe->tong_ton,
            ]);

        $topBinhLuanMoi = BienThe::with(['binhluan' => function ($query) {
                $query->orderByDesc('created_at')->limit(1);
            }])
            ->with('sanpham', 'khoiluong', 'nhanbanh', 'binhluan.user') 
            ->whereHas('binhluan')
            ->get()
            ->sortByDesc(function ($bienThe) {
                return $bienThe->binhluan->first()->created_at ?? null;
            })
            ->take(5)
            ->map(fn($bt) => [
                'id'            => $bt->id,
                'sanpham'       => $bt->sanpham,
                'khoiluong'     => $bt->khoiluong,
                'nhanbanh'      => $bt->nhanbanh,
                'binhluan_moi'  => $bt->binhluan->first(),
            ]);

        $donhangs = Donhang::when($from && $to, fn($q) =>
                            $q->whereBetween('created_at', [
                                Carbon::parse($from)->startOfDay(),
                                Carbon::parse($to)->endOfDay()
                            ])
                        )
                        ->where('trangthai', 'đã giao')
                        ->get();

        $tongDonHang  = $donhangs->count();
        $tongDoanhThu = $donhangs->sum('thanhtien');

        $topBanChay = DonHangChiTiet::select('id_bienthe', DB::raw('SUM(soluong) as tongban'))
            ->groupBy('id_bienthe')
            ->orderByDesc('tongban')
            ->with('bienthe.sanpham', 'bienthe.khoiluong', 'bienthe.nhanbanh') 
            ->take(5)
            ->get();

        $topNguoiDungChiTieu = Donhang::where('trangthai', 'đã giao')
            ->select('id_user', DB::raw('SUM(tongtien) as tong_chi_tieu'))
            ->groupBy('id_user')
            ->orderByDesc('tong_chi_tieu')
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'user'       => User::find($item->id_user),
                'tong_chi'   => $item->tong_chi_tieu,
            ]);

        $baivietByDanhMuc = DanhMucBaiViet::withCount('baiviet')
            ->withSum('baiviet', 'luotxem')
            ->get()
            ->map(fn($dm) => [
                'tendm'          => $dm->tendm,
                'so_baiviet'     => $dm->baiviet_count,
                'tong_luotxem'   => $dm->baiviet_sum_luotxem ?? 0,
            ]);

        return view('thongke', compact(
            'topTonKhoNhieu',
            'topTonKhoIt',
            'topBinhLuanMoi',
            'tongDonHang',
            'tongDoanhThu',
            'topBanChay',
            'topNguoiDungChiTieu',
            'baivietByDanhMuc',
            'from',
            'to'
        ));
    }
}