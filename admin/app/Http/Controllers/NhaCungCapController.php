<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Nhacungcap, Sanpham};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NhaCungCapController extends Controller
{
    private function getSortNCC($query, Request $request)
    {
        $query->when($request->filled('search'), function ($q) use ($request) {
            return $q->where('tennhacungcap', 'like', '%' . $request->query('search') . '%');
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
        $query = Nhacungcap::query();

        $this->getSortNCC($query, $request);

        $nhacungcaps = $query->paginate($perPage)->appends($request->only([
            'search',
            'sort',
            'thutu',
            'anhien',
            'per_page',
        ]));

        $totalNhacungcap = $nhacungcaps->total();

        $spCount = Sanpham::selectRaw('id_nhacungcap, COUNT(*) as total')
            ->groupBy('id_nhacungcap')
            ->pluck('total', 'id_nhacungcap')
            ->toArray();

        foreach ($nhacungcaps as $ncc) {
            $ncc->sanpham_count = $spCount[$ncc->id] ?? 0;
        }

        return view('NhaCungCap', compact('nhacungcaps', 'totalNhacungcap'));
    }

    public function detail($id)
    {
        $nhacungcap = Nhacungcap::findOrFail($id);

        $spCount = Sanpham::selectRaw('id_nhacungcap, COUNT(*) as total')
            ->groupBy('id_nhacungcap')
            ->pluck('total', 'id_nhacungcap')
            ->toArray();

        $nhacungcap->sanpham_count = $spCount[$nhacungcap->id] ?? 0;

        return view('NhaCungCap.Detail', compact('nhacungcap'));
    }

    public function create()
    {
        return view('NhaCungCap.Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tennhacungcap' => 'required|string|max:255|unique:nhacungcap,tennhacungcap',
            'thutu' => 'required|integer|min:0',
            'anhien' => 'required|in:0,1',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $thutu = $validated['thutu'];

            Nhacungcap::where('thutu', '>=', $thutu)
                ->orderBy('thutu', 'asc')
                ->increment('thutu');

            $hinhanhPath = null;
            if ($request->hasFile('hinhanh')) {
                $hinhanhPath = $request->file('hinhanh')->store('nhacungcap', 'public');
            }

            Nhacungcap::create([
                'tennhacungcap' => $validated['tennhacungcap'],
                'thutu' => $thutu,
                'anhien' => $validated['anhien'],
                'hinhanh' => $hinhanhPath,
            ]);

            return redirect()->route('nhacungcap.index')
                ->with('success', 'Nhà cung cấp đã được thêm thành công!');
        });
    }

    public function edit($id)
    {
        $nhacungcap = Nhacungcap::findOrFail($id);
        return view('NhaCungCap.Update', compact('nhacungcap'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tennhacungcap' => 'required|string|max:255|unique:nhacungcap,tennhacungcap,' . $id,
            'thutu' => 'required|integer|min:0',
            'anhien' => 'required|in:0,1',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return DB::transaction(function () use ($validated, $request, $id) {
            $nhacungcap = Nhacungcap::findOrFail($id);
            $newThutu = $validated['thutu'];
            $oldThutu = $nhacungcap->thutu;

            if ($oldThutu === $newThutu) {
                $hinhanhPath = $nhacungcap->hinhanh;
                if ($request->hasFile('hinhanh')) {
                    if ($nhacungcap->hinhanh) {
                        Storage::disk('public')->delete($nhacungcap->hinhanh);
                    }
                    $hinhanhPath = $request->file('hinhanh')->store('nhacungcaps', 'public');
                }

                $nhacungcap->update([
                    'tennhacungcap' => $validated['tennhacungcap'],
                    'thutu' => $newThutu,
                    'anhien' => $validated['anhien'],
                    'hinhanh' => $hinhanhPath,
                ]);
                return redirect()->route('nhacungcap.detail', $id)
                    ->with('success', 'Nhà cung cấp đã được cập nhật thành công!');
            }

            if ($newThutu > $oldThutu) {
                Nhacungcap::where('thutu', '>', $oldThutu)
                    ->where('thutu', '<=', $newThutu)
                    ->where('id', '!=', $id)
                    ->decrement('thutu');
            } else {
                Nhacungcap::where('thutu', '>=', $newThutu)
                    ->where('thutu', '<', $oldThutu)
                    ->where('id', '!=', $id)
                    ->increment('thutu');
            }

            $hinhanhPath = $nhacungcap->hinhanh;
            if ($request->hasFile('hinhanh')) {
                if ($nhacungcap->hinhanh) {
                    Storage::disk('public')->delete($nhacungcap->hinhanh);
                }
                $hinhanhPath = $request->file('hinhanh')->store('nhacungcaps', 'public');
            }

            $nhacungcap->update([
                'tennhacungcap' => $validated['tennhacungcap'],
                'thutu' => $newThutu,
                'anhien' => $validated['anhien'],
                'hinhanh' => $hinhanhPath,
            ]);

            $allNhacungcaps = Nhacungcap::orderBy('thutu', 'asc')->get();
            $expectedThutu = 1;
            foreach ($allNhacungcaps as $ncc) {
                if ($ncc->thutu !== $expectedThutu) {
                    $ncc->update(['thutu' => $expectedThutu]);
                }
                $expectedThutu++;
            }

            return redirect()->route('nhacungcap.detail', $id)
                ->with('success', 'Nhà cung cấp đã được cập nhật thành công!');
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $nhacungcap = Nhacungcap::findOrFail($id);

            $sanphamCount = Sanpham::where('id_nhacungcap', $nhacungcap->id)->count();
            if ($sanphamCount > 0) {
                return redirect()->route('nhacungcap.index')
                    ->with('error', 'Nhà cung cấp đang có sản phẩm, không thể xóa.');
            }

            $currentThutu = $nhacungcap->thutu;
            if ($currentThutu !== null) {
                $nextThutu = Nhacungcap::where('thutu', '>', $currentThutu)
                    ->min('thutu');

                Nhacungcap::where('thutu', '>', $currentThutu)
                    ->decrement('thutu');

                if ($nextThutu !== null) {
                    $adjustedThutu = $nextThutu - 1;
                    $previousThutu = Nhacungcap::where('thutu', '<', $currentThutu)
                        ->max('thutu');

                    if ($previousThutu !== null && $adjustedThutu <= $previousThutu) {
                        Nhacungcap::where('thutu', '>=', $previousThutu + 1)
                            ->increment('thutu');
                    }
                }
            }

            if ($nhacungcap->hinhanh) {
                Storage::disk('public')->delete($nhacungcap->hinhanh);
            }

            $nhacungcap->delete();

            return redirect()->route('nhacungcap.index')
                ->with('success', 'Nhà cung cấp đã được xóa thành công.');
        });
    }

    public function active($id)
    {
        Nhacungcap::where('id', $id)->update(['anhien' => 0]);
        return redirect()->route('nhacungcap.index')->with('success', 'Nhà cung cấp đã hiện');
    }

    public function unactive($id)
    {
        Nhacungcap::where('id', $id)->update(['anhien' => 1]);
        return redirect()->route('nhacungcap.index')->with('success', 'Nhà cung cấp đã ẩn');
    }

    public function checkThutu(Request $request)
    {
        $thutu = $request->input('thutu');
        $exists = Nhacungcap::where('thutu', $thutu)->exists();
        return response()->json(['exists' => $exists]);
    }
}