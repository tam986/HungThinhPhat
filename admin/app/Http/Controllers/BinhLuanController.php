<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BinhLuan;
use Illuminate\Support\Facades\DB;

class BinhLuanController extends Controller
{
   
    public function index()
    {
        $comments = BinhLuan::with(['bienthe.sanpham', 'user'])->paginate(10);
        return view('Binhluan', compact('comments'));
    }

    public function duyet($id)
    {
        $comment = BinhLuan::findOrFail($id);
        $comment->update(['trangthai' => 'đã duyệt']);
        return redirect()->back()->with('success', 'Bình luận đã được duyệt.');
    }

    public function tuchoi($id)
    {
        $comment = BinhLuan::findOrFail($id);
        $comment->update(['trangthai' => 'từ chối']);
        return redirect()->back()->with('success', 'Bình luận đã bị ẩn.');
    }
    public function active($id)
    {
        $comment = BinhLuan::findOrFail($id);
        $comment->update(['anhien' => 0]);
        return redirect()->back()->with('success', 'Bình luận đã được hiển thị.');
    }

    public function unactive($id)
    {
        $comment = BinhLuan::findOrFail($id);
        $comment->update(['anhien' => 1]);
        return redirect()->back()->with('success', 'Bình luận đã bị ẩn.');
    }
}
