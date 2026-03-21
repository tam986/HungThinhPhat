<?php

namespace App\Http\Controllers;

use App\Models\LoaiBanh;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoaiBanhController extends Controller
{
    public function index(Request $request)
    {
        $query = LoaiBanh::query()->withCount('bienthe');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('tenLoaiBanh', 'like', "%$search%");
        }

        $cakeTypes = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('CakeTypes/Index', [
            'cakeTypes' => $cakeTypes,
            'filters' => $request->all(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('CakeTypes/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenLoaiBanh' => 'required|string|max:255|unique:loaibanhs,tenLoaiBanh',
        ], [
            'tenLoaiBanh.required' => 'Vui lòng nhập tên loại bánh.',
            'tenLoaiBanh.unique' => 'Tên loại bánh này đã tồn tại.',
        ]);

        LoaiBanh::create($validated);

        flash()->success('Thêm loại bánh mới thành công!', ['timeout' => 2000]);
        return redirect()->route('loaibanh.index');
    }

    public function edit($id)
    {
        $cakeType = LoaiBanh::findOrFail($id);
        return Inertia::render('CakeTypes/Edit', [
            'cakeType' => $cakeType
        ]);
    }

    public function update(Request $request, $id)
    {
        $cakeType = LoaiBanh::findOrFail($id);

        $validated = $request->validate([
            'tenLoaiBanh' => 'required|string|max:255|unique:loaibanhs,tenLoaiBanh,' . $id,
        ], [
            'tenLoaiBanh.required' => 'Vui lòng nhập tên loại bánh.',
            'tenLoaiBanh.unique' => 'Tên loại bánh này đã tồn tại.',
        ]);

        $cakeType->update($validated);

        flash()->success('Cập nhật loại bánh thành công!', ['timeout' => 2000]);
        return redirect()->route('loaibanh.index');
    }

    public function destroy($id)
    {
        $cakeType = LoaiBanh::withCount('bienthe')->findOrFail($id);

        if ($cakeType->bienthe_count > 0) {
            flash()->error('Không thể xóa loại bánh đang có sản phẩm sử dụng!', ['timeout' => 3000]);
            return redirect()->back();
        }

        $cakeType->delete();

        flash()->success('Xóa loại bánh thành công!', ['timeout' => 2000]);
        return redirect()->route('loaibanh.index');
    }
}
