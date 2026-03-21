<?php

namespace App\Http\Controllers;

use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

use Inertia\Inertia;

class DanhMucBaiVietController extends Controller
{
    public function index()
    {
        $danhmucs = DanhMucBaiViet::all();

        return Inertia::render('PostCategories/Index', [
            'danhmucs' => $danhmucs
        ]);
    }

    public function create()
    {
        return Inertia::render('PostCategories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tendm' => 'required|max:30',
            'thutu' => 'nullable|integer',
            'anhien' => 'nullable|integer',
        ]);

        DanhMucBaiViet::create([
            'tendm' => $request->tendm,
            'thutu' => $request->thutu,
            'anhien' => $request->anhien,
        ]);
        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được tạo!');
    }

    public function edit($id)
    {
        $danhmuc = DanhMucBaiViet::findOrFail($id);
        return Inertia::render('PostCategories/Edit', ['danhmuc' => $danhmuc]);
    }

    public function update(Request $request, $id)
    {
        $danhmuc = DanhMucBaiViet::findOrFail($id);
        $request->validate([
            'tendm' => 'required|max:30',
            'thutu' => 'nullable|integer',
            'anhien' => 'nullable|integer',
        ]);

        $danhmuc->update($request->all());
        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy($id)
    {
        $danhmuc = DanhMucBaiViet::findOrFail($id);
        $danhmuc->delete();
        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được xóa!');
    }
}
