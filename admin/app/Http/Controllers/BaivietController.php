<?php

namespace App\Http\Controllers;

use App\Models\Baiviet;
use App\Models\DanhMucBaiViet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BaivietController extends Controller
{
    public function index(Request $request)
    {
        $query = Baiviet::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('tieude', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q2) use ($request) {
                    $q2->where('hoten', 'like', '%' . $request->search . '%');
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

        $baiViets = $query->paginate(10);

        $danhMucBaiViet = DanhMucBaiViet::all();

        $user = User::all();
        return view('BaiViet', compact('baiViets', 'danhMucBaiViet', 'user'));
    }

    public function trashed()
    {
        $deletedPost = Baiviet::onlyTrashed()->get();
        return view('AdminPost.TrashedPost', compact('deletedPost'));
    }
    public function create()
    {
        $danhMucBaiViet = DanhMucBaiViet::all();
        return view('AdminPost.Create', compact('danhMucBaiViet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:baiviets,slug',
            'seotieude' => 'nullable|string|max:255',
            'motangan' => 'nullable|string',
            'noidung' => 'required|string',
            'anhdaidien' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'id_danhmuc' => 'required|exists:danh_muc_bai_viet,id',
            'anhien' => 'required|boolean',
        ]);

        $anhdaidien_path = null; // Khởi tạo đường dẫn là null
            if ($request->hasFile('anhdaidien')) {
                $file = $request->file('anhdaidien');
                $originalFileName = $file->getClientOriginalName();
                $directory = 'uploads/posts'; // <-- Sửa thành đúng thư mục này
                $disk = 'public';
        
                // Lưu file vào đúng thư mục với tên gốc
                $anhdaidien_path = $file->storeAs($directory, $originalFileName, $disk);
            }


        Baiviet::create([
            'tieude' => $request->tieude,
            'slug' => $request->slug,
            'seotieude' => $request->seotieude,
            'motangan' => $request->motangan,
            'noidung' => $request->noidung,
            'anhdaidien' => $anhdaidien_path,
            'id_danhmuc' => $request->id_danhmuc,
            'id_user' => Auth::id(),
            'anhien' => $request->anhien

        ]);

        return redirect()->route('baiviet.index')->with('success', 'Bài viết đã được tạo thành công.');
    }

    public function show($id)
    {
        $baiViet = Baiviet::with('danhmucbaiviet')->findOrFail($id);
        return view('AdminPost.Detail', compact('baiViet'));
    }

    public function edit($id)
    {
        $baiViet = Baiviet::findOrFail($id);
        $danhMucBaiViet = DanhMucBaiViet::all();
        return view('AdminPost.Update', compact('baiViet', 'danhMucBaiViet'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tieude' => 'required|string|max:255',
            'motangan' => 'nullable|string',
            'noidung' => 'required|string',
            'anhdaidien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seotieude' => 'required|string',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('baiviets', 'slug')->ignore($id)->whereNull('deleted_at'),
            ],
            'id_danhmuc' => 'required|exists:danh_muc_bai_viet,id',
            'anhien' => 'required|boolean',

        ]);
        $baiViet = BaiViet::findOrFail($id);

        if ($request->hasFile('anhdaidien')) {
        $file = $request->file('anhdaidien');
        $originalFileName = $file->getClientOriginalName();
        $directory = 'uploads/posts';
        $disk = 'public';
        $path = $file->storeAs($directory, $originalFileName, $disk);
        $validated['anhdaidien'] = $path;
    
        } else {
             $validated['anhdaidien'] = $baiViet->anhdaidien; 
        }
        $baiViet->update([
            'tieude' => $validated['tieude'],
            'motangan' => $validated['motangan'],
            'noidung' => $validated['noidung'],
            'anhdaidien' => $validated['anhdaidien'],
            'seotieude' => $validated['seotieude'],
            'slug' => $validated['slug'],
            'id_danhmuc' => $validated['id_danhmuc'],
            'anhien' => $validated['anhien'],

            'id_user' => Auth::id(),
        ]);

        return redirect()->route('baiviet.index')->with('success', 'Cập nhật bài viết thành công');
    }

    public function softDelete($id)
    {
        $baiviet = BaiViet::findOrFail($id);
        $baiviet->delete();

        return redirect()->back()->with('success', 'Đã xóa mềm bài viết thành công.');
    }

    public function restore($id)
    {
        $baiviet = BaiViet::withTrashed()->findOrFail($id);
        $baiviet->restore();

        return redirect()->back()->with('success', 'Đã khôi phục bài viết thành công.');
    }

    public function forceDelete($id)
    {
        $baiviet = BaiViet::withTrashed()->findOrFail($id);
        $baiviet->forceDelete();

        return redirect()->back()->with('success', 'Đã xóa vĩnh viễn bài viết.');
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
