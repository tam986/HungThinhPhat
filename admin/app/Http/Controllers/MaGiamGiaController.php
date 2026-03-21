<?php

namespace App\Http\Controllers;

use App\Models\Magiamgia;
use Illuminate\Http\Request;

use Inertia\Inertia;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        $magiamgia = Magiamgia::orderBy('thoidiemketthuc', 'desc')->paginate(10);
        
        return Inertia::render('Coupons/Index', [
            'coupons' => $magiamgia
        ]);
    }
    public function create()
    {
        $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
        return Inertia::render('Coupons/Create', ['now' => $now]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'magiamgia' => 'required|unique:phieugiamgia,magiamgia|max:50',
            'hesogiamgia' => 'required|numeric|min:0',
            'sotientoithieu' => 'required|numeric|min:0',
            'soluong' => 'required|integer|min:0',
            'thoidiembatdau' => 'required|date|after_or_equal:now',
            'thoidiemketthuc' => 'required|date|after:thoidiembatdau',
            'trangthai' => 'required|integer'
        ], [
            'thoidiembatdau.after_or_equal' => 'Ngày bắt đầu không được trong quá khứ.',
            'thoidiemketthuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.'
        ]);

        $data = $request->all();
        $data['thoidiembatdau'] = \Carbon\Carbon::parse($request->thoidiembatdau)->toDateTimeString();
        $data['thoidiemketthuc'] = \Carbon\Carbon::parse($request->thoidiemketthuc)->toDateTimeString();

        Magiamgia::create($data);

        return redirect()->route('magiamgia.index')->with('success', 'Thêm mã giảm giá thành công!');
    }

    public function edit($id)
    {
        $magiamgia = Magiamgia::findOrFail($id);
        // Format dates for datetime-local input
        $magiamgia->thoidiembatdau = \Carbon\Carbon::parse($magiamgia->thoidiembatdau)->format('Y-m-d\TH:i');
        $magiamgia->thoidiemketthuc = \Carbon\Carbon::parse($magiamgia->thoidiemketthuc)->format('Y-m-d\TH:i');
        
        return Inertia::render('Coupons/Edit', ['coupon' => $magiamgia]);
    }

    public function update(Request $request, $id)
    {
        $magiamgia = Magiamgia::findOrFail($id);

        $request->validate([
            'magiamgia' => 'required|max:50|unique:phieugiamgia,magiamgia,' . $id,
            'hesogiamgia' => 'required|numeric|min:0',
            'sotientoithieu' => 'required|numeric|min:0',
            'soluong' => 'required|integer|min:0',
            'thoidiembatdau' => 'required|date|after_or_equal:now',
            'thoidiemketthuc' => 'required|date|after:thoidiembatdau',
            'trangthai' => 'required|integer'
        ], [
            'thoidiembatdau.after_or_equal' => 'Ngày bắt đầu không được trong quá khứ.',
            'thoidiemketthuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.'
        ]);

        $data = $request->all();
        $data['thoidiembatdau'] = \Carbon\Carbon::parse($request->thoidiembatdau)->toDateTimeString();
        $data['thoidiemketthuc'] = \Carbon\Carbon::parse($request->thoidiemketthuc)->toDateTimeString();

        if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($data['thoidiemketthuc']))) {
            $data['trangthai'] = 1; // Assuming 1 means expired or inactive
        }

        $magiamgia->update($data);

        return redirect()->route('magiamgia.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy(string $id)
    {
        Magiamgia::findOrFail($id)->delete();
        return redirect()->route('magiamgia.index')->with('success', 'Mã giảm giá đã được xóa!');
    }
}
