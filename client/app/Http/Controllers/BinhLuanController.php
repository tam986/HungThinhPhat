<?php

namespace App\Http\Controllers;

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
            flash()->error('Vui lòng đăng nhập để bình luận.');
            return redirect()->back();
        }

        $hasPurchased = Donhang::where('id_user', $user->id)
            ->whereHas('donhangchitiet', function ($query) use ($request) {
                $query->where('id_bienthe', $request->id_bienthe);
            })
            ->where('trangthai', 'hoàn thành')
            ->exists();

        if (!$hasPurchased) {
            flash()->error('Bạn cần mua sản phẩm này để bình luận.');
            return redirect()->back();
        }

        BinhLuan::create([
            'id_bienthe' => $request->id_bienthe,
            'id_user' => $user->id,
            'noidung' => $request->noidung,
            'trangthai' => 'chờ duyệt',
        ]);
        flash()->success('Bình luận của bạn đã được gửi và đang chờ duyệt.');
        return redirect()->back();
    }
}
