<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\BienThe;
use App\Models\Khoiluong;
use App\Models\Nhanbanh;
use App\Models\Nhacungcap;
use App\Models\Danhmuc;
use App\Models\Sanpham;
use App\Models\Loaibanh;

use Inertia\Inertia;

class AdminSPController extends Controller
{
    private function getSortSp($query, Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $danhmuc = $request->query('danhmuc');
        $nhacungcap = $request->query('nhacungcap');
        $status = $request->query('status');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('tensp', 'like', "%{$search}%")
                  ->orWhereHas('danhmuc', function ($sub) use ($search) {
                      $sub->where('tendanhmuc', 'like', "%{$search}%");
                  })
                  ->orWhereHas('nhacungcap', function ($sub) use ($search) {
                      $sub->where('tennhacungcap', 'like', "%{$search}%");
                  });
            });
        }

        if ($danhmuc) {
            $query->where('id_danhmuc', $danhmuc);
        }

        if ($nhacungcap) {
            $query->where('id_nhacungcap', $nhacungcap);
        }

        if ($status !== null) {
            $query->where('anhien', $status);
        }

        if ($sort === 'latest') {
            $query->orderByDesc('id');
        } elseif ($sort === 'name') {
            $query->orderBy('tensp', 'asc');
        } elseif ($sort === 'name-asc') {
            $query->orderBy('tensp', 'asc');
        } elseif ($sort === 'name-desc') {
            $query->orderBy('tensp', 'desc');
        } elseif ($sort === 'stock-desc') {
            $query->orderBy('total_stock', 'desc');
        } else {
            $query->orderByDesc('id');
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Sanpham::query()
            ->with(['danhmuc', 'nhacungcap', 'bienthe' => function($q) {
                $q->with(['khoiluong', 'nhanbanh'])->select('id', 'id_sp', 'hinh', 'id_khoiluong', 'id_nhanbanh');
            }])
            ->withCount('bienthe as variant_count')
            ->withSum('bienthe as total_stock', 'soluong')
            ->withMin('bienthe as min_price', 'gia')
            ->withMax('bienthe as max_price', 'gia');

        $this->getSortSp($query, $request);

        $sanphams = $query->paginate($perPage)->withQueryString();

        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all(['id', 'tennhacungcap']);

        return Inertia::render('Products/Index', [
            'sanphams' => $sanphams,
            'danhmucs' => $danhmucs,
            'nhacungcaps' => $nhacungcaps,
            'filters' => $request->only(['search', 'sort', 'danhmuc', 'nhacungcap', 'status'])
        ]);
    }

    public function trashed(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Sanpham::onlyTrashed()->with(['bienthe' => function($q) {
            $q->select('id', 'id_sp', 'hinh');
        }, 'danhmuc', 'nhacungcap']);
        $this->getSortSp($query, $request);

        $trashedSanphams = $query->paginate($perPage)->withQueryString();
        $this->getTotalSp($trashedSanphams);

        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all(['id', 'tennhacungcap']);

        return Inertia::render('Products/Trashed', [
            'sanphams' => $trashedSanphams,
            'danhmucs' => $danhmucs,
            'nhacungcaps' => $nhacungcaps,
            'filters' => $request->only(['search', 'sort', 'danhmuc', 'nhacungcap', 'status'])
        ]);
    }

    public function detail($id)
    {
        $product = Sanpham::with([
            'bienthe.khoiluong',
            'bienthe.nhanbanh',
            'danhmuc',
            'nhacungcap'
        ])->findOrFail($id);

        $khoiluongs = Khoiluong::all();
        $nhanbanhs = Nhanbanh::all();

        return Inertia::render('Products/Detail', [
            'product' => $product,
            'khoiluongs' => $khoiluongs,
            'nhanbanhs' => $nhanbanhs,
        ]);
    }


    public function create()
    {
        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all();
        $khoiluong = Khoiluong::all();
        $nhanbanh = Nhanbanh::all();
        
        return Inertia::render('Products/Create', [
            'danhmucs' => $danhmucs,
            'nhacungcaps' => $nhacungcaps,
            'khoiluong' => $khoiluong,
            'nhanbanh' => $nhanbanh,
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tensp' => 'required|string|max:255',
            'id_danhmuc' => 'required|exists:danhmucs,id',
            'id_nhacungcap' => 'required|exists:nhacungcaps,id',
            'mota' => 'nullable|string',
            'anhien' => 'required|boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
        ]);

        $sanpham = Sanpham::create([
            'tensp' => $validatedData['tensp'],
            'id_danhmuc' => $validatedData['id_danhmuc'],
            'id_nhacungcap' => $validatedData['id_nhacungcap'],
            'mota' => $validatedData['mota'] ?? '',
            'anhien' => $validatedData['anhien'],
            'is_featured' => $request->boolean('is_featured'),
            'is_new' => $request->boolean('is_new'),
        ]);

        return redirect()->route('sanpham.detail', $sanpham->id)->with('success', 'Sản phẩm đã được tạo! Hãy thêm các biến thể bên dưới.');
    }

    public function edit($id)
    {
        // Lấy sản phẩm cùng tất cả biến thể
        $sanpham = Sanpham::with(['bienthe.nhanbanh', 'bienthe.khoiluong', 'danhmuc', 'nhacungcap'])->findOrFail($id);

        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all();
        $nhanbanh = Nhanbanh::all();
        $khoiluong = Khoiluong::all();

        return Inertia::render('Products/Edit', [
            'sanpham' => $sanpham,
            'danhmucs' => $danhmucs,
            'nhacungcaps' => $nhacungcaps,
            'nhanbanh' => $nhanbanh,
            'khoiluong' => $khoiluong,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tensp' => 'required|string|max:255',
            'id_danhmuc' => 'required|exists:danhmucs,id',
            'id_nhacungcap' => 'required|exists:nhacungcaps,id',
            'mota' => 'nullable|string',
            'anhien' => 'required|boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
        ]);

        $product = Sanpham::findOrFail($id);
        
        $product->update([
            'tensp' => $validatedData['tensp'],
            'id_danhmuc' => $validatedData['id_danhmuc'],
            'id_nhacungcap' => $validatedData['id_nhacungcap'],
            'mota' => $validatedData['mota'] ?? '',
            'anhien' => $validatedData['anhien'],
            'is_featured' => $request->boolean('is_featured'),
            'is_new' => $request->boolean('is_new'),
        ]);

        return redirect()->route('sanpham.detail', $id)->with('success', 'Thông tin sản phẩm đã được cập nhật thành công!');
    }

    public function storeVariant(Request $request, $id_sp)
    {
        $validated = $request->validate([
            'id_khoiluong' => 'required|exists:khoiluongs,id',
            'id_nhanbanh' => 'nullable|exists:nhanbanhs,id',
            'gia' => 'required|numeric|min:0',
            'giakm' => 'nullable|numeric|min:0',
            'soluong' => 'required|integer|min:0',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:10048',
        ]);

        $imagePath = null;
        if ($request->hasFile('hinh')) {
            $imagePath = $request->file('hinh')->store('uploads/img-sp', 'public');
        }

        $variant = BienThe::create(array_merge($validated, [
            'id_sp' => $id_sp,
            'hinh' => $imagePath,
            'slug' => 'temp-' . uniqid(), // Will update after creation to use full name
        ]));

        // Tự động tạo slug từ full_name (không cần ID để URL sạch hơn)
        $variant->update(['slug' => \Illuminate\Support\Str::slug($variant->full_name)]);

        return back()->with('success', 'Biến thể mới đã được thêm thành công!');
    }

    /**
     * Store multiple variants at once (Step 2 of creation/update).
     */
    public function storeBulkVariants(Request $request, $id_sp)
    {
        $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*.id_khoiluong' => 'required|exists:khoiluongs,id',
            'variants.*.id_nhanbanh' => 'nullable|exists:nhanbanhs,id',
            'variants.*.gia' => 'required|numeric|min:0',
            'variants.*.giakm' => 'nullable|numeric|min:0',
            'variants.*.soluong' => 'required|integer|min:0',
            'variants.*.hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
        ]);

        $product = Sanpham::findOrFail($id_sp);
        $count = 0;

        foreach ($request->variants as $index => $vData) {
            // Check if combination already exists
            $exists = BienThe::where('id_sp', $id_sp)
                ->where('id_khoiluong', $vData['id_khoiluong'])
                ->where('id_nhanbanh', $vData['id_nhanbanh'] ?? null)
                ->exists();

            if ($exists) continue;

            // Xử lý tệp hình ảnh
            $imagePath = null;
            if ($request->hasFile("variants.$index.hinh")) {
                $imagePath = $request->file("variants.$index.hinh")->store('variants', 'public');
            }

            $variant = BienThe::create([
                'id_sp' => $id_sp,
                'id_khoiluong' => $vData['id_khoiluong'],
                'id_nhanbanh' => $vData['id_nhanbanh'] ?? null,
                'gia' => $vData['gia'],
                'giakm' => $vData['giakm'] ?? null,
                'soluong' => $vData['soluong'],
                'hinh' => $imagePath,
                'slug' => 'temp-' . uniqid(),
            ]);

            // Update slug based on full_name attribute
            $variant->update([
                'slug' => \Illuminate\Support\Str::slug($variant->full_name)
            ]);
            $count++;
        }

        return back()->with('success', "Đã tạo thành công {$count} biến thể mới!");
    }

    public function updateVariant(Request $request, $id)
    {
        $variant = BienThe::findOrFail($id);
        $validated = $request->validate([
            'id_khoiluong' => 'required|exists:khoiluongs,id',
            'id_nhanbanh' => 'nullable|exists:nhanbanhs,id',
            'gia' => 'required|numeric|min:0',
            'giakm' => 'nullable|numeric|min:0',
            'soluong' => 'required|integer|min:0',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:10048',
        ]);

        $imagePath = $variant->hinh;
        if ($request->hasFile('hinh')) {
            $imagePath = $request->file('hinh')->store('uploads/img-sp', 'public');
        }

        $variant->update(array_merge($validated, [
            'hinh' => $imagePath,
            'slug' => \Illuminate\Support\Str::slug($variant->full_name),
        ]));

        return back()->with('success', 'Biến thể đã được cập nhật thành công!');
    }

    public function destroyVariant($id)
    {
        $variant = BienThe::findOrFail($id);
        // Optional: delete image file
        if ($variant->hinh && file_exists(storage_path('app/public/' . $variant->hinh))) {
            unlink(storage_path('app/public/' . $variant->hinh));
        }
        $variant->delete();
        return back()->with('success', 'Biến thể đã được xoá thành công!');
    }

    public function updateStatus(Request $request, $id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $validated = $request->validate([
            'anhien' => 'required|string',
        ]);

        $sanpham->update(['anhien' => $validated['anhien']]);

        return redirect()->route('sanpham.index')->with('success', 'Trạng thái sản phẩm đã được cập nhật!');
    }

    public function toggleFeatured($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $sanpham->update(['is_featured' => !$sanpham->is_featured]);
        return redirect()->route('sanpham.index')->with('success', 'Đã cập nhật trạng thái Nổi bật!');
    }

    public function toggleNew($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $sanpham->update(['is_new' => !$sanpham->is_new]);
        return redirect()->route('sanpham.index')->with('success', 'Đã cập nhật trạng thái Sản phẩm mới!');
    }

    public function softDelete($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $sanpham->delete();
        return redirect()->route('sanpham.index', ['sort' => 'latest'])
            ->with('success', 'Sản phẩm đã được chuyển vào thùng rác.');
    }

    public function restore($id)
    {
        $sanpham = Sanpham::onlyTrashed()->findOrFail($id);
        $sanpham->restore();

        return redirect()->route('sanpham.trashed')->with('success', 'Sản phẩm đã được khôi phục.');
    }

    public function destroy($id)
    {
        $sanpham = Sanpham::onlyTrashed()->with('bienthe')->findOrFail($id);
        
        // Xóa tất cả ảnh của các biến thể trong storage
        foreach ($sanpham->bienthe as $variant) {
            if ($variant->hinh) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($variant->hinh);
            }
        }

        // Xóa biến thể và sản phẩm khỏi DB
        $sanpham->bienthe()->delete();
        $sanpham->forceDelete();

        return redirect()->route('sanpham.trashed')
            ->with('success', 'Sản phẩm và toàn bộ biến thể (bao gồm hình ảnh) đã được xóa vĩnh viễn.');
    }

  public function getKhoiluongNhanbanh($id_sp)
    {
        // Lấy danh sách biến thể theo sản phẩm
        $bientheList = BienThe::where('id_sp', $id_sp)->get();


        $idKhoiluongs = $bientheList->pluck('id_khoiluong')->unique();
        $idNhanbanhs = $bientheList->pluck('id_nhanBanh')->unique();

        // Do bảng khoiluongs chỉ có cột id => dùng whereIn('id', ...)
        $khoiluongs = Khoiluong::whereIn('id', $idKhoiluongs)->get(['id', 'khoiluong']);
        $nhanbanhs = Nhanbanh::whereIn('id', $idNhanbanhs)->get(['id', 'tenNhanBanh']);

        return response()->json([
            'khoiluongs' => $khoiluongs,
            'nhanbanhs' => $nhanbanhs,
        ]);
    }
    public function getBienThe(Request $request)
    {

      
       $id_sp = $request->input('id_sp');
        $id_khoiluong = $request->input('id_khoiluong');
        $id_nhanbanh = $request->input('id_nhanBanh');


        if (!$id_sp || !$id_khoiluong || !$id_nhanbanh) {
            return response()->json(['error' => 'Thiếu tham số'], 400);
        }

         $bienThe = BienThe::where([
            'id_sp' => $id_sp,
            'id_khoiluong' => $id_khoiluong,
            'id_nhanBanh' => $id_nhanbanh
        ])->first();

        if ($bienThe) {
            return response()->json([
                'id' => $bienThe->id,
                'gia' => (float)$bienThe->gia,
                'giakm' => (float)($bienThe->giakm ?? 0),
                'soluong' => (int)$bienThe->soluong,
                'slug' => $bienThe->sanpham->slug ?? null,
            ]);
        }

        return response()->json(['message' => 'Không tìm thấy'], 404);
    }
}
