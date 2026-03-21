<?php

namespace App\Http\Controllers;

use App\Models\BienThe;
use App\Models\Khoiluong;
use Illuminate\Http\Request;

use Inertia\Inertia;

class KhoiLuongController extends Controller
{
    private function getSortKL($query, Request $request)
    {
        $query->when($request->filled('search'), function ($q) use ($request) {
            return $q->where('khoiluong', 'like', '%' . $request->query('search') . '%');
        });

        $sort = $request->query('sort');
        $query->when($sort, function ($q) use ($sort) {
            if ($sort === 'latest') {
                return $q->orderByDesc('id');
            }
        });
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Khoiluong::query();

        $this->getSortKL($query, $request);

        $khoiluongs = $query->paginate($perPage)->withQueryString();

        $btCount = BienThe::selectRaw('id_khoiluong, COUNT(*) as total')
            ->groupBy('id_khoiluong')
            ->pluck('total', 'id_khoiluong')
            ->toArray();

        foreach ($khoiluongs as $kl) {
            $kl->bienthe_count = $btCount[$kl->id] ?? 0;
        }

        return Inertia::render('Weights/Index', [
            'weights' => $khoiluongs,
            'filters' => $request->only(['search', 'sort', 'per_page'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Weights/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'khoiluong' => 'required|string|max:255|unique:khoiluongs,khoiluong',
        ]);

        Khoiluong::create([
            'khoiluong' => $validated['khoiluong'],
        ]);

        return redirect()->route('khoiluong.index')
            ->with('success', 'Khối lượng đã được thêm thành công!');
    }

    public function edit($id)
    {
        $khoiluong = Khoiluong::findOrFail($id);
        return Inertia::render('Weights/Edit', ['weight' => $khoiluong]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'khoiluong' => 'required|string|max:255|unique:khoiluongs,khoiluong,' . $id,
        ]);

        $khoiluong = Khoiluong::findOrFail($id);
        $khoiluong->update([
            'khoiluong' => $validated['khoiluong'],
        ]);

        return redirect()->route('khoiluong.index')
            ->with('success', 'Khối lượng đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $khoiluong = Khoiluong::findOrFail($id);

        $bientheCount = BienThe::where('id_khoiluong', $khoiluong->id)->count();
        if ($bientheCount > 0) {
            return redirect()->route('khoiluong.index')
                ->with('error', 'Khối lượng đang được sử dụng trong ' . $bientheCount . ' biến thể, không thể xóa.');
        }

        $khoiluong->delete();

        return redirect()->route('khoiluong.index')
            ->with('success', 'Khối lượng đã được xóa thành công.');
    }
}
