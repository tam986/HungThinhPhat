<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Baiviet;
use App\Models\BienThe;
use App\Models\Danhmuc;
use App\Models\Magiamgia;
use App\Models\Sanpham;
use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Bước 1: Lấy tất cả danh mục có sản phẩm hiển thị
        $allCategories = Danhmuc::orderBy('thutu', 'asc')->get();
        $categoryIds = $allCategories->pluck('id');

        // Bước 2: 1 query duy nhất lấy bienthes của các danh mục đó (tránh N+1)
        $allBienThes = BienThe::with(['sanpham.danhmuc', 'khoiluong', 'nhanbanh'])
            ->whereHas('sanpham', fn($q) => $q->whereIn('id_danhmuc', $categoryIds)->where('anhien', 1))
            ->latest()
            ->get();

        // Gom nhóm trong PHP (không cần thêm query)
        $groupedBienThes = $allBienThes->groupBy(fn($bt) => $bt->sanpham?->id_danhmuc ?? 0);

        $productCate = $allCategories->map(function ($category) use ($groupedBienThes) {
            $bienthes = $groupedBienThes->get($category->id, collect())->take(5);
            $category->products = \App\Http\Resources\ProductResource::collection($bienthes);
            return $category;
        });

        $danhmucs = $allCategories;

        return response()->json(compact('danhmucs', 'productCate'));
    }
    public function footer()
    {
        $danhmucAll = Danhmuc::orderBy('tendanhmuc', 'asc')->get();
        $danhmucBv = DanhMucBaiViet::orderBy('tendm', 'asc')->get();
        return response()->json(compact('danhmucAll', 'danhmucBv'));
    }
}
