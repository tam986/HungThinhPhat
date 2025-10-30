<?php

namespace App\Http\Controllers;

use App\Models\Magiamgia;
use Illuminate\Http\Request;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        $magiamgia = Magiamgia::orderBy('thoidiemketthuc', 'desc')->paginate(10);
        return view('Magiamgia', compact('magiamgia'));
    }
    public function create()
    {
        $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
        return view('Magiamgia.Create', compact('now'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'magiamgia' => 'required|unique:phieugiamgia|max:50',
            'hesogiamgia' => 'required|numeric|min:0',
            'sotientoithieu' => 'required|numeric|min:0',
            'soluong' => 'required|integer|min:0',
            'thoidiembatdau' => 'required|date|after_or_equal:now',
            'thoidiemketthuc' => 'required|date|after:thoidiembatdau',
            'trangthai' => 'required|integer'
        ]);
        $data = $request->all();
        $data['thoidiembatdau'] = date('Y-m-d H:i:s', strtotime($request->thoidiembatdau));
        $data['thoidiemketthuc'] = date('Y-m-d H:i:s', strtotime($request->thoidiemketthuc));
        Magiamgia::create($data);
        return redirect()->route('magiamgia.index')->with('success', 'Thêm mã giảm giá thành công!');
    }
    public function edit($id)
    {
        $magiamgia = Magiamgia::findOrFail($id);
        return view('Magiamgia.Update', compact('magiamgia'));
    }
    public function update(Request $request, $id)
    {
        $magiamgia = Magiamgia::findOrFail($id);

        $request->validate([
            'hesogiamgia' => 'required|numeric|min:0',
            'sotientoithieu' => 'required|numeric|min:0',
            'soluong' => 'required|integer|min:0',
            'thoidiembatdau' => 'required|date|after_or_equal:now',
            'thoidiemketthuc' => 'required|date|after:thoidiembatdau',
            'trangthai' => 'required|integer'
        ]);

        $data = $request->all();


        $data['thoidiembatdau'] = date('Y-m-d H:i:s', strtotime($request->thoidiembatdau));
        $data['thoidiemketthuc'] = date('Y-m-d H:i:s', strtotime($request->thoidiemketthuc));


        if (now()->greaterThan($data['thoidiemketthuc'])) {
            $data['trangthai'] = 1;
        }

        $magiamgia->update($data);

        return redirect()->route('magiamgia.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy(string $id)
    {
        Magiamgia::where('id', $id)->delete();
        return redirect()->route('magiamgia.index')->with('success', 'Mã giảm giá đã được xóa!');
    }
}
