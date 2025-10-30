<?php

namespace App\Http\Controllers;

use App\Models\Baiviet;
use App\Models\Danhmuc;
use App\Models\DanhMucBaiViet;
use App\Models\Donhang;
use App\Models\Sanpham;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashBoardController extends Controller
{

    public function index()
    {

        $tongbaiviet = Baiviet::orderBy('id', 'desc')->count();
        $baiViets = Baiviet::where('anhien', 1)->paginate(10);
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $tongsanpham = Sanpham::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $tongdonhangmoi = Donhang::where('created_at', '>=', Carbon::now()->subDay())
            ->count();
        $listkhachhangmoi = User::where('created_at', '>=', Carbon::now()->subDay())->get();
        $danhmucCountSP = Danhmuc::select('id', 'tendanhmuc')
            ->selectRaw('(SELECT COUNT(*) FROM sanphams WHERE sanphams.id_danhmuc = danhmucs.id) as so_sanpham')
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();
        // -----doanh thu---------------------
        $doanhThuThangNay = Carbon::now()->month;
        $doanhThuThangTruoc = Carbon::now()->subMonth()->month;

        // Tổng doanh thu tháng này
        $tongDoanhThuThangNay = Donhang::where('trangthai', 'hoàn thành')
            ->whereMonth('created_at', $doanhThuThangNay)
            ->sum('thanhtien');

        // Tổng doanh thu tháng trước
        $tongDoanhThuThangTruoc = Donhang::where('trangthai', 'hoàn thành')
            ->whereMonth('created_at', $doanhThuThangTruoc)
            ->sum('thanhtien');


        $phanTramDoanhThu = 0;
        if ($tongDoanhThuThangTruoc > 0) {
            $phanTramDoanhThu = (($tongDoanhThuThangNay - $tongDoanhThuThangTruoc) / $tongDoanhThuThangTruoc) * 100;
        }

        $danhMucBaiViet = DanhMucBaiViet::all();
        return view('welcome', compact('tongbaiviet', 'tongsanpham', 'tongdonhangmoi', 'listkhachhangmoi', 'danhmucCountSP', 'tongDoanhThuThangNay', 'phanTramDoanhThu', 'baiViets', 'danhMucBaiViet'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
