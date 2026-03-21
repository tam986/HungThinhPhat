<?php

namespace App\Http\Controllers;

use App\Models\Baiviet;
use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

class BaivietController extends Controller
{
    public function index()
    {
        $baiviet = Baiviet::with('danhmuc')
            ->orderBy('id', 'asc')
            ->paginate(8);
        $baivietMoi = Baiviet::with('danhmuc')
            ->orderBy('created_at', 'desc')
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
        return view('Baiviet', compact(
            'baivietMoi',
            'baivietXemNhieu',
            'baivietXemNhanh',
            'danhmuc',
            'danhmucDuLich',
            'baivietDulich',
            'baivietAmthuc',
            'baivietTintuc',
            'danhmucTinTuc',
            'danhmucAmthuc'
        ));
    }

    public function search(Request $request)
    {
        $query = Baiviet::query();

        if ($request->has('danhmuc') && $request->danhmuc != '') {
            $query->where('id_danhmuc', $request->danhmuc);
        }

        if ($request->has('keyword') && $request->keyword != '') {
            $query->where(function ($q) use ($request) {
                $q->where('tieude', 'like', '%' . $request->keyword . '%')
                    ->orWhere('noidung', 'like', '%' . $request->keyword . '%');
            });
        }

        $baiviet = $query->paginate(10);
        $danhmuc = DanhMucBaiViet::all();

        return view('Baiviet-partials.search_baiviet', compact('baiviet', 'danhmuc'));
    }
    public function theoDanhMuc($id)
    {
        $danhmucChon = DanhMucBaiViet::find($id);
        $soLuongBaiVietNoiBat = 4;
        $baiVietNoiBat = Baiviet::where('id_danhmuc', $id)
            ->orderBy('luotxem', 'desc')
            ->limit($soLuongBaiVietNoiBat)
            ->get();

        $baiVietChinh = $baiVietNoiBat->first();
        $baiVietPhu = $baiVietNoiBat->slice(1);
        $featuredIds = $baiVietNoiBat->pluck('id');
        $baiViet = Baiviet::where('id_danhmuc', $id)
            ->whereNotIn('id', $featuredIds)
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        $danhmuc = DanhMucBaiViet::all();

        $baivietMoi = Baiviet::orderBy('created_at', 'desc')->limit(8)->get();
        $baivietXemNhieu = Baiviet::orderBy('luotxem', 'desc')->limit(8)->get();


        return view('pages.Baivietdanhmuc', compact(
            'baiVietChinh',
            'baiVietPhu',
            'baiViet',
            'danhmuc',
            'danhmucChon',
            'baivietMoi',
            'baivietXemNhieu'
        ));
    }

    public function show($slug)
    {
        $baiviet = Baiviet::with('danhmuc')->where('slug', $slug)->firstOrFail();
        $danhmuc = DanhMucBaiViet::all();

        $baiviet->increment('luotxem');

        $baivietLienQuan = Baiviet::where('id_danhmuc', $baiviet->id_danhmuc)
            ->where('id', '!=', $baiviet->id)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('baiviet-partials.ShowBaiviet', compact('baiviet', 'baivietLienQuan', 'danhmuc'));
    }
}
