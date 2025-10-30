<?php

namespace App\Http\Controllers;

use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

class DanhMucBaiVietController extends Controller
{
    public function index()
    {
        $danhmucs = DanhMucBaiViet::all();

        return view('DanhMucBaiViet', compact('danhmucs'));
    }

    public function create()
    {
        return view('DanhMucBaiViet.Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tendm' => 'required|max:30',
            'thutu' => 'nullable|string',
            'anhien' => 'nullable|string',
        ]);

        DanhMucBaiViet::create([
            'tendm' => $request->tendm,
            'thutu' => $request->thutu,
            'anhien' => $request->anhien,

        ]);
        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được tạo!');
    }

    public function edit(string $id)

    {
        $danhmuc = DanhMucBaiViet::find($id);
        return view('DanhMucBaiViet.Update', compact('danhmuc'));
    }

    public function update(Request $request, DanhMucBaiViet $id)
    {
        $request->validate([
            'tendm' => 'required|max:30',
            'thutu' => 'nullable|string',
            'anhien' => 'nullable|string',
        ]);

        $id->update($request->all());
        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy(DanhMucBaiViet $danhmuc)
    {
        $danhmuc->delete();
        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được xóa!');
    }
}
