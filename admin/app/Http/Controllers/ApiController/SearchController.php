<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Baiviet;
use App\Models\Bienthe;
use App\Models\Danhmuc;
use App\Models\DanhMucBaiViet;
use App\Models\Nhacungcap;
use App\Models\Sanpham;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $kyw = $request->input('query');

        $bienthes = Bienthe::with([
            'sanpham.danhmuc',
            'sanpham.nhacungcap',
            'khoiluong',
            'nhanbanh'
        ])->whereHas('sanpham', function ($q) use ($kyw) {
            $q->whereNull('deleted_at')
                ->where('tensp', 'LIKE', "%$kyw%");
        })->paginate(12);
        $danhmucs = Danhmuc::where('anhien', 0)->orderBy('thutu')->get();
        $nhacungcaps = Nhacungcap::where('anhien', 1)->get();

        return response()->json([
            'kyw' => $kyw,
            'bienthes' => $bienthes,
            'danhmucs' => $danhmucs,
            'nhacungcaps' => $nhacungcaps,
            'baiviets' => $baiviets,
            'baivietMoi' => $baivietMoi,
            'baivietXemNhieu' => $baivietXemNhieu,
            'baivietXemNhanh' => $baivietXemNhanh,
            'danhmucBaiViet' => $danhmuc,
            'danhmucDuLich' => $danhmucDuLich,
            'baivietDulich' => $baivietDulich,
            'baivietAmthuc' => $baivietAmthuc,
            'baivietTintuc' => $baivietTintuc,
            'danhmucTinTuc' => $danhmucTinTuc,
            'danhmucAmthuc' => $danhmucAmthuc,
        ]);
    }
}
