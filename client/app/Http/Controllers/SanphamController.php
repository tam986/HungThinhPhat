<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use App\Models\Danhmuc;
use App\Models\Nhacungcap;
use App\Models\Bienthe;
use App\Models\Yeuthich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanphamController extends Controller
{
    public function index(Request $request)
    {
        $query = Bienthe::with([
            'sanpham.danhmuc',
            'sanpham.nhacungcap',
            'khoiluong',
            'nhanbanh'
        ])->whereHas('sanpham', function ($q) use ($request) {
            $q->whereNull('deleted_at');

            if ($search = $request->query('search')) {
                $q->where('tensp', 'like', '%' . $search . '%');
            }

            if ($danhmucFilter = $request->query('category')) {
                $q->whereIn('id_danhmuc', (array) $danhmucFilter);
            }

            if ($nccFilter = $request->query('supplier')) {
                $q->whereIn('id_nhacungcap', (array) $nccFilter);
            }
        });

        switch ($request->query('sort')) {
            case 'price-asc':
                $query->orderBy('gia');
                break;
            case 'price-desc':
                $query->orderByDesc('gia');
                break;
            default:
                $query->orderByDesc('id');
                break;
        }

        $bienthes = $query->paginate(12)->withQueryString();

        $danhmucs = Danhmuc::where('anhien', 0)->orderBy('thutu')->get();
        $nhacungcaps = Nhacungcap::where('anhien', 1)->get();

        return view('Sanpham', compact('bienthes', 'danhmucs', 'nhacungcaps'));
    }
    public function detail($slug)
    {   
        $selectedBienthe = Bienthe::with([
            'sanpham.danhmuc',
            'sanpham.nhacungcap',
            'khoiluong',
            'nhanbanh'
        ])
            ->where('slug', $slug)
            ->firstOrFail();
        $sanpham = $selectedBienthe->sanpham;
        $sanphamTuongtu = Sanpham::where('id', '!=', $selectedBienthe->id_sp)
            ->whereNull('deleted_at')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('Sanphamchitiet', compact('selectedBienthe', 'sanphamTuongtu'));
    }
    public function updateLuotXem($id)
    {
        $sp = Sanpham::find($id);
        if ($sp) {
            $sp->increment('luotxem');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function uploadYeuThich(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $id_bienthe = $request->input('id_bienthe');
            $yeuthich = Yeuthich::where('id_user', $user->id)->where('id_sp', $id_bienthe)->first();

            if ($yeuthich) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm đã có trong danh sách yêu thích']);
            } else {
                Yeuthich::create(['id_user' => $user->id, 'id_sp' => $id_bienthe]);
                return response()->json(['success' => true, 'message' => 'Đã thêm sản phẩm vào danh sách yêu thích']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích']);
    }
}