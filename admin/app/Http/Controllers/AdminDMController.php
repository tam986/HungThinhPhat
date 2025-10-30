<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Danhmuc, Sanpham};
use Illuminate\Support\Facades\DB;

class AdminDMController extends Controller
{
    private function getSortDM($query, Request $request)
    {
        $query->when($request->filled('search'), function ($q) use ($request) {
            return $q->where('tendanhmuc', 'like', '%' . $request->query('search') . '%');
        });

        $query->when($request->has('thutu'), function ($q) use ($request) {
            return $q->where('thutu', $request->query('thutu'));
        });

        $query->when($request->has('anhien'), function ($q) use ($request) {
            return $q->where('anhien', $request->query('anhien'));
        });

        $sort = $request->query('sort');
        $query->when($sort, function ($q) use ($sort) {
            if ($sort === 'latest') {
                return $q->orderByDesc('id');
            } elseif ($sort === 'thutu-asc') {
                return $q->orderBy('thutu', 'asc');
            } elseif ($sort === 'thutu-desc') {
                return $q->orderBy('thutu', 'desc');
            }
        });
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Danhmuc::query();

        $this->getSortDM($query, $request);

        $danhmucs = $query->paginate($perPage)->appends($request->only([
            'search',
            'sort',
            'thutu',
            'anhien',
            'per_page',
        ]));

        $totalDanhmuc = $danhmucs->total();

        $spCount = Sanpham::selectRaw('id_danhmuc, COUNT(*) as total')
            ->groupBy('id_danhmuc')
            ->pluck('total', 'id_danhmuc')
            ->toArray();

        foreach ($danhmucs as $dm) {
            $dm->sanpham_count = $spCount[$dm->id] ?? 0;
        }

        return view('DanhMuc', compact('danhmucs', 'totalDanhmuc'));
    }

    public function detail($id)
    {
        $danhmuc = Danhmuc::findOrFail($id);

        $spCount = Sanpham::selectRaw('id_danhmuc, COUNT(*) as total')
            ->groupBy('id_danhmuc')
            ->pluck('total', 'id_danhmuc')
            ->toArray();

        $danhmuc->sanpham_count = $spCount[$danhmuc->id] ?? 0;

        return view('AdminDm.Detail', compact('danhmuc'));
    }

    public function create()
    {
        return view('AdminDm.Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tendanhmuc' => 'required|string|max:255|unique:danhmucs,tendanhmuc',
            'thutu' => 'required|integer|min:0',
            'anhien' => 'required|in:0,1',
            'mota' => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($validated) {
            $thutu = $validated['thutu'];

            Danhmuc::where('thutu', '>=', $thutu)
                ->orderBy('thutu', 'asc')
                ->increment('thutu');

            Danhmuc::create([
                'tendanhmuc' => $validated['tendanhmuc'],
                'thutu' => $thutu,
                'anhien' => $validated['anhien'],
                'mota' => $validated['mota'],
            ]);

            return redirect()->route('danhmucDM.index')
                ->with('success', 'Danh mục đã được thêm thành công!');
        });
    }

    public function edit($id)
    {
        $danhmuc = Danhmuc::findOrFail($id);
        return view('AdminDm.Update', compact('danhmuc'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tendanhmuc' => 'required|string|max:255|unique:danhmucs,tendanhmuc,' . $id,
            'thutu' => 'required|integer|min:0',
            'anhien' => 'required|in:0,1',
            'mota' => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($validated, $id) {
            $danhmuc = Danhmuc::findOrFail($id);
            $newThutu = $validated['thutu'];
            $oldThutu = $danhmuc->thutu;

            if ($oldThutu === $newThutu) {
                $danhmuc->update([
                    'tendanhmuc' => $validated['tendanhmuc'],
                    'thutu' => $newThutu,
                    'anhien' => $validated['anhien'],
                    'mota' => $validated['mota'],
                ]);
                return redirect()->route('danhmucDM.detail', $id)
                    ->with('success', 'Danh mục đã được cập nhật thành công!');
            }

            if ($newThutu > $oldThutu) {
                Danhmuc::where('thutu', '>', $oldThutu)
                    ->where('thutu', '<=', $newThutu)
                    ->where('id', '!=', $id)
                    ->decrement('thutu');
            } else {
                Danhmuc::where('thutu', '>=', $newThutu)
                    ->where('thutu', '<', $oldThutu)
                    ->where('id', '!=', $id)
                    ->increment('thutu');
            }

            $danhmuc->update([
                'tendanhmuc' => $validated['tendanhmuc'],
                'thutu' => $newThutu,
                'anhien' => $validated['anhien'],
                'mota' => $validated['mota'],
            ]);

            $allDanhmucs = Danhmuc::orderBy('thutu', 'asc')->get();
            $expectedThutu = 1;
            foreach ($allDanhmucs as $dm) {
                if ($dm->thutu !== $expectedThutu) {
                    $dm->update(['thutu' => $expectedThutu]);
                }
                $expectedThutu++;
            }

            return redirect()->route('danhmucDM.detail', $id)
                ->with('success', 'Danh mục đã được cập nhật thành công!');
        });
    }

    public function destroy($id)
    {
        $danhmuc = Danhmuc::findOrFail($id);

        $sanphamCount = Sanpham::where('id_danhmuc', $danhmuc->id)->count();

        if ($sanphamCount > 0) {
            return redirect()->route('danhmucDM.index')
                ->with('error', 'Danh mục đang có sản phẩm, không thể xóa.');
        }

        $danhmuc->delete();

        return redirect()->route('danhmucDM.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }

    public function active($id)
    {
        Danhmuc::where('id', $id)->update(['anhien' => 0]);
        return redirect()->route('danhmucDM.index')->with('success', 'Danh mục đã ẩn');
    }
    public function unactive($id)
    {
        Danhmuc::where('id', $id)->update(['anhien' => 1]);
        return redirect()->route('danhmucDM.index')->with('success', 'Danh mục đã hiện');
    }

    public function checkThutu(Request $request)
    {
        $thutu = $request->input('thutu');

        $exists = Danhmuc::where('thutu', $thutu)->exists();

        return response()->json(['exists' => $exists]);
    }
}
