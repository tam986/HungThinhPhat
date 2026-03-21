<?php

namespace App\Http\Controllers;

use App\Models\Baiviet;
use App\Models\DanhMucBaiViet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Inertia\Inertia;

class BaivietController extends Controller
{
    public function index(Request $request)
    {
        $query = Baiviet::with(['user', 'danhmucbaiviet']);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('tieude', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q2) use ($request) {
                      $q2->where('hoten', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('id_danhmuc', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('anhien', $request->status);
        }

        if ($request->has('sort')) {
            if ($request->sort == 'latest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort == 'az') {
                $query->orderBy('tieude', 'asc');
            } elseif ($request->sort == 'za') {
                $query->orderBy('tieude', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $baiViets = $query->paginate(10)->withQueryString();

        $baiViets->getCollection()->transform(function ($post) {
            $post->anhdaidien_url = $post->anhdaidien ? Storage::url($post->anhdaidien) : null;
            return $post;
        });

        $danhMucBaiViet = DanhMucBaiViet::all();

        return Inertia::render('Posts/Index', [
            'posts' => $baiViets,
            'categories' => $danhMucBaiViet,
            'filters' => $request->only(['search', 'category', 'status', 'sort'])
        ]);
    }

    public function trashed(Request $request)
    {
        $query = Baiviet::onlyTrashed()->with(['user', 'danhmucbaiviet']);
        
        if ($request->has('search') && $request->search != '') {
            $query->where('tieude', 'like', '%' . $request->search . '%');
        }

        $deletedPosts = $query->paginate(10);
        $deletedPosts->getCollection()->transform(function ($post) {
            $post->anhdaidien_url = $post->anhdaidien ? Storage::url($post->anhdaidien) : null;
            return $post;
        });

        return Inertia::render('Posts/Trashed', [
            'posts' => $deletedPosts,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $categories = DanhMucBaiViet::all();
        return Inertia::render('Posts/Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieude' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:baiviets,slug',
            'seotieude' => 'nullable|string|max:255',
            'motangan' => 'nullable|string',
            'noidung' => 'required|string',
            'anhdaidien' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
            'id_danhmuc' => 'required|exists:danh_muc_bai_viet,id',
            'anhien' => 'required|in:0,1',
        ]);

        if ($request->hasFile('anhdaidien')) {
            $validated['anhdaidien'] = $request->file('anhdaidien')->store('uploads/posts', 'public');
        }

        $validated['id_user'] = Auth::id();
        Baiviet::create($validated);

        return redirect()->route('baiviet.index')->with('success', 'Bài viết đã được tạo thành công.');
    }

    public function show($id)
    {
        $post = Baiviet::with(['user', 'danhmucbaiviet'])->findOrFail($id);
        $post->anhdaidien_url = $post->anhdaidien ? Storage::url($post->anhdaidien) : null;
        return Inertia::render('Posts/Detail', ['post' => $post]);
    }

    public function edit($id)
    {
        $post = Baiviet::findOrFail($id);
        $post->anhdaidien_url = $post->anhdaidien ? Storage::url($post->anhdaidien) : null;
        $categories = DanhMucBaiViet::all();
        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Baiviet::findOrFail($id);
        
        $validated = $request->validate([
            'tieude' => 'required|string|max:255',
            'motangan' => 'nullable|string',
            'noidung' => 'required|string',
            'anhdaidien' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
            'seotieude' => 'nullable|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('baiviets', 'slug')->ignore($id)->whereNull('deleted_at'),
            ],
            'id_danhmuc' => 'required|exists:danh_muc_bai_viet,id',
            'anhien' => 'required|in:0,1',
        ]);

        if ($request->hasFile('anhdaidien')) {
            if ($post->anhdaidien) {
                Storage::disk('public')->delete($post->anhdaidien);
            }
            $validated['anhdaidien'] = $request->file('anhdaidien')->store('uploads/posts', 'public');
        }

        $validated['id_user'] = Auth::id();
        $post->update($validated);

        return redirect()->route('baiviet.index')->with('success', 'Cập nhật bài viết thành công');
    }

    public function softDelete($id)
    {
        $post = Baiviet::findOrFail($id);
        $post->delete();
        return redirect()->route('baiviet.index')->with('success', 'Đã chuyển bài viết vào thùng rác.');
    }

    public function restore($id)
    {
        $post = Baiviet::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('baiviet.trashed')->with('success', 'Đã khôi phục bài viết.');
    }

    public function forceDelete($id)
    {
        $post = Baiviet::withTrashed()->findOrFail($id);
        if ($post->anhdaidien) {
            Storage::disk('public')->delete($post->anhdaidien);
        }
        $post->forceDelete();
        return redirect()->route('baiviet.trashed')->with('success', 'Đã xóa vĩnh viễn bài viết.');
    }


    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            $originName = $file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            $file->storeAs('uploads/posts', $fileNameToStore, 'public');

            $url = asset('storage/uploads/posts/' . $fileNameToStore);

            return response()->json([
                'fileNameToStore' => $fileNameToStore,
                'uploaded' => 1,
                'url' => $url
            ]);
        }
    }
}
