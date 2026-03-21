<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('thutu', 'asc')->get()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'tieude' => $banner->tieude,
                'duongdan' => $banner->duongdan,
                'thutu' => $banner->thutu,
                'anhien' => $banner->anhien,
                'hinhanh' => $banner->hinhanh ? Storage::url($banner->hinhanh) : null,
            ];
        });
        return Inertia::render('Banners/Index', ['banners' => $banners]);
    }

    public function create()
    {
        return Inertia::render('Banners/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieude' => 'nullable|string|max:255',
            'duongdan' => 'nullable|string|max:255',
            'thutu' => 'required|integer|min:0',
            'anhien' => 'required|in:0,1',
            'hinhanh' => 'required|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
        ]);

        if ($request->hasFile('hinhanh')) {
            $path = $request->file('hinhanh')->store('uploads/banners', 'public');
            $validated['hinhanh'] = $path;
        }

        Banner::create($validated);

        return redirect()->route('banners.index')->with('success', 'Thêm banner thành công!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->hinhanh_url = $banner->hinhanh ? Storage::url($banner->hinhanh) : null;
        return Inertia::render('Banners/Edit', ['banner' => $banner]);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $validated = $request->validate([
            'tieude' => 'nullable|string|max:255',
            'duongdan' => 'nullable|string|max:255',
            'thutu' => 'required|integer|min:0',
            'anhien' => 'required|in:0,1',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
        ]);

        if ($request->hasFile('hinhanh')) {
            // Xóa ảnh cũ
            if ($banner->hinhanh) {
                Storage::disk('public')->delete($banner->hinhanh);
            }
            
            $path = $request->file('hinhanh')->store('uploads/banners', 'public');
            $validated['hinhanh'] = $path;
        }

        $banner->update($validated);

        return redirect()->route('banners.index')->with('success', 'Cập nhật banner thành công!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->hinhanh) {
            Storage::disk('public')->delete($banner->hinhanh);
        }
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Xóa banner thành công!');
    }

    public function active($id)
    {
        Banner::where('id', $id)->update(['anhien' => 1]);
        return back()->with('success', 'Đã hiện banner');
    }

    public function unactive($id)
    {
        Banner::where('id', $id)->update(['anhien' => 0]);
        return back()->with('success', 'Đã ẩn banner');
    }
}
