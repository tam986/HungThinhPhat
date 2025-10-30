<?php

namespace App\Http\Controllers;

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

        if ($bienthes->count() > 0) {
            return view('Sanpham', [
                'bienthes' => $bienthes,
                'kyw' => $kyw,
                'danhmucs' => $danhmucs,
                'nhacungcaps' => $nhacungcaps
            ]);
        }

       $baiviets = Baiviet::with('danhmuc')
    ->where('tieude', 'LIKE', "%$kyw%")
    ->orWhere('motangan', 'LIKE', "%$kyw%")
    ->orWhereHas('danhmuc', function ($q) use ($kyw) {
        $q->where('tendm', 'LIKE', '%' . $kyw . '%');
    })
    ->paginate(8);


        $baivietMoi = Baiviet::with('danhmuc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        $baivietXemNhieu = Baiviet::with('danhmuc')
            ->orderBy('luotxem', 'desc')
            ->limit(4)
            ->get();
        $danhmucDuLich = DanhMucBaiViet::find(5);
        $danhmucTinTuc = DanhMucBaiViet::find(6);
        $danhmucAmthuc = DanhMucBaiViet::find(7);
        $baivietDulich = Baiviet::with('danhmuc')
            ->where('id_danhmuc', 5)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        $baivietTintuc = Baiviet::with('danhmuc')
            ->where('id_danhmuc', 6)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        $baivietAmthuc = Baiviet::with('danhmuc')
            ->where('id_danhmuc', 7)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        $baivietXemNhanh = Baiviet::orderBy('created_at', 'desc')->limit(3)->get();
        $danhmuc = DanhMucBaiViet::withCount('baiviet')->get();

        if ($baiviets->count() > 0) {
            return view('Baiviet', [
                'baiviets' => $baiviets,
                'kyw' => $kyw,
                'baiviets',
                'kyw',
                'baivietMoi' => $baivietMoi,
                'baivietXemNhieu' => $baivietXemNhieu,
                'baivietXemNhanh' => $baivietXemNhanh,
                'danhmuc' => $danhmuc,
                'danhmucDuLich' => $danhmucDuLich,
                'baivietDulich' => $baivietDulich,
                'baivietAmthuc' => $baivietAmthuc,
                'baivietTintuc' => $baivietTintuc,
                'danhmucTinTuc' => $danhmucTinTuc,
                'danhmucAmthuc' => $danhmucAmthuc,

            ]);
        }


        return view('pages.search', ['kyw' => $kyw]);
    }
}
