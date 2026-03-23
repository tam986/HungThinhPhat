<?php

namespace App\Http\Controllers;

use App\Models\Baiviet;
use App\Models\Danhmuc;
use App\Models\DanhMucBaiViet;
use App\Models\Donhang;
use App\Models\Sanpham;
use App\Models\BienThe;
use App\Models\DonHangChiTiet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{

    public function index()
    {
        // 1. Metrics Calculation
        $now = Carbon::now();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // Revenue (Completed orders only)
        $revenueThisMonth = Donhang::where('trangthai', 'hoàn thành')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('thanhtien');

        $revenueLastMonth = Donhang::where('trangthai', 'hoàn thành')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('thanhtien');

        $revenuePercent = 0;
        if ($revenueLastMonth > 0) {
            $revenuePercent = (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100;
        }

        // Orders metrics
        $newOrders24h = Donhang::where('created_at', '>=', now()->subDay())->count();
        $pendingOrders = Donhang::where('trangthai', 'chờ xác nhận')->count();
        $totalProducts = Sanpham::count();

        // 2. Actionables
        $latestOrders = Donhang::orderByDesc('created_at')
            ->take(10)
            ->get(['id', 'tennguoinhan', 'phone', 'thanhtien', 'trangthai', 'created_at']);

        $lowStockVariants = BienThe::with(['sanpham', 'loaibanh', 'khoiluong', 'nhanbanh'])
            ->where('soluong', '<', 10)
            ->orderBy('soluong', 'asc')
            ->take(5)
            ->get();

        // 3. Overview
        // Top 5 selling variants
        $topSellers = DonHangChiTiet::select('id_bienthe', DB::raw('SUM(soluong) as total_sold'))
            ->groupBy('id_bienthe')
            ->orderByDesc('total_sold')
            ->with(['bienthe.sanpham', 'bienthe.loaibanh'])
            ->take(5)
            ->get();

       

        return \Inertia\Inertia::render('Dashboard', [
            'metrics' => [
                'revenueThisMonth' => $revenueThisMonth,
                'revenuePercent' => round($revenuePercent, 1),
                'newOrders24h' => $newOrders24h,
                'pendingOrders' => $pendingOrders,
                'totalProducts' => $totalProducts,
            ],
            'actionables' => [
                'latestOrders' => $latestOrders,
                'lowStockVariants' => $lowStockVariants,
            ],
            'overview' => [
                'topSellers' => $topSellers,
              
            ]
        ]);
    }
}
