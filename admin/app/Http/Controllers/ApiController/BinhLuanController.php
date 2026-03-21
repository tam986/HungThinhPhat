<?php

namespace App\Http\Controllers\ApiController;

use App\Models\BinhLuan;
use App\Models\Donhang;
use App\Models\Donhangchitiet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BinhLuanController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'noidung' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để bình luận.'], 401);
        }

        $hasPurchased = Donhang::where('id_user', $user->id)
            ->whereHas('donhangchitiet', function ($query) use ($request) {
                $query->where('id_bienthe', $request->id_bienthe);
            })
            ->where('trangthai', 'hoàn thành')
            ->exists();

        if (!$hasPurchased) {
            return response()->json(['success' => false, 'message' => 'Bạn cần mua sản phẩm này để bình luận.'], 403);
        }

        BinhLuan::create([
            'id_bienthe' => $request->id_bienthe,
            'id_user' => $user->id,
            'noidung' => $request->noidung,
            'trangthai' => 'chờ duyệt',
        ]);
        return response()->json(['success' => true, 'message' => 'Bình luận của bạn đã được gửi và đang chờ duyệt.']);
    }
}
