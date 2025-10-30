<?php

namespace App\Http\Controllers;

use App\Models\BienThe;
use App\Models\Nhanbanh;
use Illuminate\Http\Request;

class NhanBanhController extends Controller
{
  private function getSortNB($query, Request $request)
  {
    $query->when($request->filled('search'), function ($q) use ($request) {
      return $q->where('tenNhanBanh', 'like', '%' . $request->query('search') . '%');
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
    $query = NhanBanh::query();

    $this->getSortNB($query, $request);

    $nhanbanhs = $query->paginate($perPage)->appends($request->only([
      'search',
      'sort',
      'per_page',
    ]));

    $totalNhanBanh = $nhanbanhs->total();

    $btCount = BienThe::selectRaw('id_nhanbanh, COUNT(*) as total')
      ->groupBy('id_nhanbanh')
      ->pluck('total', 'id_nhanbanh')
      ->toArray();

    foreach ($nhanbanhs as $nb) {
      $nb->bienthe_count = $btCount[$nb->id] ?? 0;
    }

    return view('Nhanbanh', compact('nhanbanhs', 'totalNhanBanh'));
  }

  public function create()
  {
    return view('NhanBanh.Create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'tenNhanBanh' => 'required|string|max:255|unique:nhanbanhs,tenNhanBanh',
    ]);

    NhanBanh::create([
      'tenNhanBanh' => $validated['tenNhanBanh'],
    ]);

    return redirect()->route('nhanbanh.index')
      ->with('success', 'Nhân bánh đã được thêm thành công!');
  }

  public function edit($id)
  {
    $nhanbanh = NhanBanh::findOrFail($id);
    return view('NhanBanh.Update', compact('nhanbanh'));
  }

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'tenNhanBanh' => 'required|string|max:255|unique:nhanbanhs,tenNhanBanh,' . $id,
    ]);

    $nhanbanh = NhanBanh::findOrFail($id);
    $nhanbanh->update([
      'tenNhanBanh' => $validated['tenNhanBanh'],
    ]);

    return redirect()->route('nhanbanh.index')
      ->with('success', 'Nhân bánh đã được cập nhật thành công!');
  }

  public function destroy($id)
  {
    $nhanbanh = NhanBanh::findOrFail($id);

    $bientheCount = BienThe::where('id_nhanbanh', $nhanbanh->id)->count();
    if ($bientheCount > 0) {
      return redirect()->route('nhanbanh.index')
        ->with('error', 'Nhân bánh đang được sử dụng trong ' . $bientheCount . ' biến thể, không thể xóa.');
    }

    $nhanbanh->delete();

    return redirect()->route('nhanbanh.index')
      ->with('success', 'Nhân bánh đã được xóa thành công.');
  }
}
