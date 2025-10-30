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

class AdminSPController extends Controller
{
    private function getTotalSp($sanphams)
    {
        $bientheSums = Bienthe::selectRaw('id_sp, SUM(soluong) as total_soluong')
            ->groupBy('id_sp')
            ->pluck('total_soluong', 'id_sp')
            ->toArray();

        foreach ($sanphams as $sp) {
            $sp->total_soluong = $bientheSums[$sp->id] ?? 0;
        }
    }

    private function getSortSp($query, Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $danhmuc = $request->query('danhmuc');
        $nhacungcap = $request->query('nhacungcap');
        $status = $request->query('status');

        if ($search) {
            $query->where('tensp', 'like', "%{$search}%")
                ->orWhereHas('danhmuc', function ($q) use ($search) {
                    $q->where('tendanhmuc', 'like', "%{$search}%");
                })
                ->orWhereHas('nhacungcap', function ($q) use ($search) {
                    $q->where('tennhacungcap', 'like', "%{$search}%");
                });
        }

        if ($danhmuc) {
            $query->where('id_danhmuc', $danhmuc);
        }

        if ($nhacungcap) {
            $query->where('id_nhacungcap', $nhacungcap);
        }

        if ($status !== null) {
            $query->where('trangthai', $status);
        }

        if ($sort === 'latest') {
            $query->orderByDesc('id');
        } elseif ($sort === 'name') {
            $query->orderBy('tensp', 'asc');
        } elseif ($sort === 'category') {
            $query->join('danhmucs', 'sanphams.id_danhmuc', '=', 'danhmucs.id')
                ->orderBy('danhmucs.tendanhmuc', 'asc')
                ->select('sanphams.*');
        } elseif ($sort === 'name-asc') {
            $query->orderBy('tensp', 'asc');
        } elseif ($sort === 'name-desc') {
            $query->orderBy('tensp', 'desc');
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Sanpham::query()->with(['bienthe', 'danhmuc', 'nhacungcap']);
        $this->getSortSp($query, $request);

        $sanphams = $query->with(['danhmuc', 'nhacungcap'])->paginate($perPage)->withQueryString();
        $this->getTotalSp($sanphams);

        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all(['id', 'tennhacungcap']);

        return view('sp', compact('sanphams', 'danhmucs', 'nhacungcaps'));
    }

    public function trashed(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Sanpham::onlyTrashed()->with(['bienthe', 'danhmuc', 'nhacungcap']);
        $this->getSortSp($query, $request);

        $trashedSanphams = $query->paginate($perPage)->withQueryString();
        $this->getTotalSp($trashedSanphams);

        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all(['id', 'tennhacungcap']);

        return view('trashed', compact('trashedSanphams', 'danhmucs', 'nhacungcaps'));
    }

    public function detail($id)
    {

        $sanpham = Sanpham::with('bienthe', 'danhmuc', 'nhacungcap')->findOrFail($id);

        $total_soluong = Bienthe::where('id_sp', $sanpham->id)->sum('soluong');

        return view('AdminSp.Detail', compact('sanpham', 'total_soluong'));
    }


    public function create()
    {
        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all();
        $khoiluong = Khoiluong::all();
        $nhanbanh = Nhanbanh::all();
        return view('AdminSp.Create', compact('danhmucs', 'nhacungcaps', 'khoiluong', 'nhanbanh'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tensp' => 'required|string|max:255',
            'id_danhmuc' => 'required|exists:danhmucs,id',
            'id_nhacungcap' => 'required|exists:nhacungcaps,id',
            'mota' => 'nullable|string',
            'anhien' => 'nullable|int|in:0,1',

            // Validate cho biến thể
            'bienthe.soluong.*' => 'required|integer|min:0',
            'bienthe.gia.*' => 'required|numeric|min:0',
            'bienthe.giakm.*' => 'nullable|numeric|min:0',
            'bienthe.hinh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'bienthe.id_nhanbanh.*' => 'nullable|exists:nhanbanhs,id',
            'bienthe.id_khoiluong.*' => 'required|exists:khoiluongs,id',
            'bienthe.slug.*' => 'required|string|max:255|distinct|unique:bienthe,slug',
        ]);

        DB::beginTransaction();
        try {
            // Tạo sản phẩm
            $sanpham = Sanpham::create([
                'tensp' => $validated['tensp'],
                'id_danhmuc' => $validated['id_danhmuc'],
                'id_nhacungcap' => $validated['id_nhacungcap'],
                'mota' => $validated['mota'],
                'anhien' => $validated['anhien'] ?? 1,
                'luotxem' => 0,
            ]);

            // Xử lý biến thể
            if ($request->has('bienthe')) {
                $bientheData = $request->input('bienthe');
                $hinhFiles = $request->file('bienthe')['hinh'] ?? [];

                foreach ($bientheData['id_khoiluong'] as $key => $id_khoiluong) {
                    $imagePath = null;

                    if (isset($hinhFiles[$key]) && $hinhFiles[$key]->isValid()) {
                        $imagePath = $hinhFiles[$key]->store('uploads/img-sp', 'public');
                    }

                    Bienthe::create([
                        'id_sp' => $sanpham->id,
                        'id_nhanbanh' => $bientheData['id_nhanbanh'][$key] ?? null,
                        'id_khoiluong' => $id_khoiluong,
                        'soluong' => $bientheData['soluong'][$key],
                        'gia' => $bientheData['gia'][$key],
                        'giakm' => $bientheData['giakm'][$key] ?? null,
                        'hinh' => $imagePath,
                        'slug' => $bientheData['slug'][$key],

                    ]);
                }
            }

            DB::commit();
            flash()->success('Thêm sản phẩm thành công!');
            return redirect()->route('sanpham.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi thêm sản phẩm hoặc biến thể: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Đã xảy ra lỗi khi thêm sản phẩm: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // Truy vấn từ Bienthe và lấy thông tin liên quan đến sản phẩm và các bảng khác
        $bienthe = Bienthe::with(['sanpham', 'sanpham.danhmuc', 'sanpham.nhacungcap'])->findOrFail($id);

        // Lấy tất cả danh mục, nhà cung cấp, nhanbanh, khoiluong để hiển thị trong form
        $danhmucs = Danhmuc::all();
        $nhacungcaps = Nhacungcap::all();
        $nhanbanh = Nhanbanh::all();
        $khoiluong = Khoiluong::all();

        // Trả về view cập nhật sản phẩm với tất cả thông tin cần thiết
        return view('AdminSp.Update', compact('bienthe', 'danhmucs', 'nhacungcaps', 'nhanbanh', 'khoiluong'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tensp' => 'required|string|max:255',
            'id_danhmuc' => 'required|exists:danhmucs,id',
            'id_nhacungcap' => 'required|exists:nhacungcaps,id',
            'mota' => 'nullable|string',
            'existing_bienthe.*.soluong' => 'required|integer|min:0',
            'existing_bienthe.*.gia' => 'required|numeric|min:0',
            'existing_bienthe.*.giakm' => 'nullable|numeric|min:0',
            'existing_bienthe.*.slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bienthe', 'slug')->ignore($id, 'id_sp') // Sử dụng Rule::unique và ignore
            ],
            'existing_bienthe.*.hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'new_bienthe.*.id_nhanbanh' => 'nullable|exists:nhanbanhs,id',
            'new_bienthe.*.id_khoiluong' => 'required|exists:khoiluongs,id',
            'new_bienthe.*.soluong' => 'required|integer|min:0',
            'new_bienthe.*.gia' => 'required|numeric|min:0',
            'new_bienthe.*.giakm' => 'nullable|numeric|min:0',
            'new_bienthe.*.slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bienthe', 'slug')
            ],
            'new_bienthe.*.hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'deleted_bienthe' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request, $id, $validatedData) {
            $product = Sanpham::findOrFail($id);
            $product->update([
                'tensp' => $validatedData['tensp'],
                'id_danhmuc' => $validatedData['id_danhmuc'],
                'id_nhacungcap' => $validatedData['id_nhacungcap'],
                'mota' => $validatedData['mota'],
            ]);

            // Xử lý deleted_bienthe
            if (!empty($validatedData['deleted_bienthe'])) {
                $deletedBientheIds = explode(',', $validatedData['deleted_bienthe']);
                $deletedBienthes = Bienthe::whereIn('id', $deletedBientheIds)->where('id_sp', $product->id)->get();
                foreach ($deletedBienthes as $bienthe) {
                    if ($bienthe->hinh && file_exists(storage_path('app/public/' . $bienthe->hinh))) {
                        unlink(storage_path('app/public/' . $bienthe->hinh));
                    }
                    $bienthe->delete();
                }
            }

            // Cập nhật existing_bienthe
            if (isset($validatedData['existing_bienthe'])) {
                foreach ($validatedData['existing_bienthe'] as $bientheId => $data) {
                    $bienthe = Bienthe::findOrFail($bientheId);
                    $updateData = [
                        'soluong' => $data['soluong'],
                        'gia' => $data['gia'],
                        'slug' => $data['slug'],
                        'giakm' => $data['giakm'] ?? null,
                    ];

                    // Xử lý hình ảnh nếu có
                    if ($request->hasFile("existing_bienthe.$bientheId.hinh") && $request->file("existing_bienthe.$bientheId.hinh")->isValid()) {
                        if ($bienthe->hinh && file_exists(storage_path('app/public/' . $bienthe->hinh))) {
                            unlink(storage_path('app/public/' . $bienthe->hinh));
                        }
                        $updateData['hinh'] = $request->file("existing_bienthe.$bientheId.hinh")->store('uploads/img-sp', 'public');
                    }

                    $bienthe->update($updateData);
                }
            }

            // Thêm mới new_bienthe
            if (isset($validatedData['new_bienthe'])) {
                foreach ($validatedData['new_bienthe'] as $index => $data) {
                    $imagePath = null;
                    if ($request->hasFile("new_bienthe.$index.hinh") && $request->file("new_bienthe.$index.hinh")->isValid()) {
                        $imagePath = $request->file("new_bienthe.$index.hinh")->store('uploads/img-sp', 'public');
                    }

                    // Tạo bản ghi mới
                    Bienthe::create([
                        'id_sp' => $product->id,
                        'id_nhanbanh' => $data['id_nhanbanh'] ?? null,
                        'id_khoiluong' => $data['id_khoiluong'],
                        'soluong' => $data['soluong'],
                        'slug' => $data['slug'],
                        'gia' => $data['gia'],
                        'giakm' => $data['giakm'] ?? null,
                        'hinh' => $imagePath,
                    ]);
                }
            }

            return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
        });
    }
    public function updateStatus(Request $request, $id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $validated = $request->validate([
            'trangthai' => 'required|in:mới,đã thêm',
        ]);

        $sanpham->update(['trangthai' => $validated['trangthai']]);

        return redirect()->route('sanpham.index')->with('success', 'Trạng thái sản phẩm đã được cập nhật!');
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

        return redirect()->back()->with('success', 'Sản phẩm đã được khôi phục.');
    }

    public function destroy($id)
    {
        $sanpham = Sanpham::onlyTrashed()->findOrFail($id);
        $sanpham->bienthe()->delete();
        $sanpham->forceDelete();

        return redirect()->route('sanpham.trashed')
            ->with('success', 'Sản phẩm và các biến thể đã được xóa vĩnh viễn.');
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
    public function getBienthe(Request $request)
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
