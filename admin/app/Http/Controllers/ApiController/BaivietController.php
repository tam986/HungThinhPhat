<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Baiviet;
use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

class BaivietController extends Controller
{
    public function index(Request $request)
    {
        $query = Baiviet::with('danhmucbaiviet');
        
        if ($search = $request->query('query')) {
            $query->where('tieude', 'like', "%{$search}%");
        }
        
        if ($slugDM = $request->query('category')) {
            $query->whereHas('danhmucbaiviet', function($q) use ($slugDM) {
                $q->where('slug', $slugDM);
            });
        }
        
        $posts = $query->where('anhien', 1)->orderBy('created_at', 'desc')->get();
        $danhmuc = DanhMucBaiViet::all();
        
        return response()->json([
            'baivietMoi' => $posts,
            'danhmuc' => $danhmuc
        ]);
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

        return response()->json(compact('baiviet', 'danhmuc'));
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


        return response()->json(compact(
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
        $baiviet = Baiviet::with(['danhmucbaiviet', 'user'])->where('slug', $slug)->firstOrFail();
        $danhmuc = DanhMucBaiViet::all();

        $baiviet->increment('luotxem');

        $baivietLienQuan = Baiviet::with(['danhmucbaiviet', 'user'])
            ->where('id_danhmuc', $baiviet->id_danhmuc)
            ->where('id', '!=', $baiviet->id)
            ->where('anhien', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Fallback if no related posts in same category: get latest overall
        if ($baivietLienQuan->isEmpty()) {
            $baivietLienQuan = Baiviet::with(['danhmucbaiviet', 'user'])
                ->where('id', '!=', $baiviet->id)
                ->where('anhien', 1)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        }

        return response()->json(compact('baiviet', 'baivietLienQuan', 'danhmuc'));
    }
}
