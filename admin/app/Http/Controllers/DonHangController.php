<?php

namespace App\Http\Controllers;

use App\Events\NewOrderNotification;
use App\Models\BienThe;
use App\Models\Donhang;
use App\Models\DonHangChiTiet;
use App\Models\Magiamgia;
use App\Models\Danhmuc;
use App\Models\Sanpham;
use App\Models\ThanhToan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DonHangController extends Controller
{
    public function index()
    {
        $orders = Donhang::orderBy('created_at', 'desc')->paginate(5);
        $magiamgias = Magiamgia::all();
        return view('DonHang', compact('orders'));
    }
    public function show($id)
    {
        $donhang = Donhang::with(['donhangchitiet', 'donhangchitiet.bienthe', 'donhangchitiet.bienthe.sanpham', 'thanhToan'])->findOrFail($id);
        return view('Donhang.Detail', compact('donhang'));
    }
     public function create()
    {
        $users = User::all();
        $sanphams = Sanpham::with(['bienthe', 'bienthe.khoiluong', 'bienthe.nhanbanh'])->get();
        $vouchers = Magiamgia::where('trangthai', 0)->get();
        $categories = Danhmuc::all();
        $danhmucAll = BienThe::with('sanpham', 'sanpham.danhmuc', 'sanpham.nhacungcap')->get();
        return view('Donhang.Create', compact('users', 'sanphams', 'vouchers', 'danhmucAll', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'tennguoinhan' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'diachi' => 'required|string|max:255',
            'thanhtoan' => 'required|string|in:pay_later',
            'vanchuyen' => 'required|string|in:fast,superFast',
            'trangthai' => 'required|string|in:chờ xác nhận,đã xác nhận,đang giao,hoàn thành,hủy',
            'id_giamgia' => 'nullable|exists:phieugiamgia,id',
            'sotiengiam' => 'nullable|integer|min:0',
            'ghichu' => 'nullable|string|max:1000',
            'order_items' => 'required|array|min:1',
            'order_items.*.id_bienthe' => 'required|exists:bienthe,id',
            'order_items.*.soluong' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $tamTinh = 0;
            $chiTietDonHang = [];

            foreach ($validated['order_items'] as $item) {
                $bienthe = Bienthe::lockForUpdate()->findOrFail($item['id_bienthe']);
                if ($item['soluong'] > $bienthe->soluong) {
                    throw new \Exception("Sản phẩm {$bienthe->id} không đủ số lượng tồn kho!");
                }
                $gia = $bienthe->giakm ?? $bienthe->gia;
                $tamTinh += $gia * $item['soluong'];
                $chiTietDonHang[] = [
                    'id_bienthe' => $bienthe->id,
                    'soluong' => $item['soluong'],
                    'gia' => $gia,
                ];
            }

            $tienGiam = $validated['sotiengiam'] ?? 0;
            $voucher = null;

            if (!empty($validated['id_giamgia'])) {
                $voucher = Magiamgia::lockForUpdate()->findOrFail($validated['id_giamgia']);
                if ($voucher->soluong <= 0) {
                    throw new \Exception("Phiếu giảm giá {$voucher->id} đã hết lượt sử dụng!");
                }
                if (isset($voucher->thoidiemketthuc) && $voucher->thoidiemketthuc < now()) {
                    throw new \Exception("Phiếu giảm giá {$voucher->id} đã hết hạn!");
                }
                if ($tamTinh < $voucher->sotientoithieu) {
                    throw new \Exception("Tổng tiền không đủ để sử dụng phiếu giảm giá {$voucher->id}!");
                }
                // $tienGiam = $voucher->hesogiamgia ?? $voucher->sotientoithieu;
            }

            $tienVC = $validated['vanchuyen'] === 'superFast' ? 50000 : 30000;
            $thanhTien = $tamTinh - $tienGiam + $tienVC;

            $donhang = DonHang::create([
                'id_user' => $validated['id_user'],
                'tennguoinhan' => $validated['tennguoinhan'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'diachi' => $validated['diachi'],
                'ghichu' => $validated['ghichu'] ?? null,
                'thanhtoan' => 'pay_later',
                'trangthai' => $validated['trangthai'],
                'id_giamgia' => $validated['id_giamgia'] ?? null,
                'tienvc' => $tienVC,
                'tongtien' => $tamTinh,
                'sotiengiam' => $tienGiam,
                'thanhtien' => $thanhTien,
            ]);

            ThanhToan::create([
                'id_donhang' => $donhang->id,
                'phuongthucthanhtoan' => 'pay_later',
                'magiaodich' => null,
                'trangthai' => 'chưa thanh toán',
                'sotienthanhtoan' => $thanhTien,
            ]);

            foreach ($chiTietDonHang as $ct) {
                $donhang->donhangchitiet()->create($ct);
                Bienthe::where('id', $ct['id_bienthe'])->decrement('soluong', $ct['soluong']);
            }

            if ($voucher) {
                $voucher->decrement('soluong');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tạo đơn hàng thành công!',
                'id_donhang' => $donhang->id,
                'data' => $donhang
            ], 201); // HTTP 201 Created
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit() {}
    public function update() {}
    public function filter(Request $request)
    {

        $from = $request->input('from');
        $to = $request->input('to');


        if (!$from || !$to) {
            $orders = Donhang::all();
        } else {
            // Định dạng ngày để tránh lỗi
            $from = Carbon::parse($from)->startOfDay();
            $to = Carbon::parse($to)->endOfDay();

            // Lọc đơn hàng theo khoảng thời gian
            $orders = Donhang::whereBetween('create_date', [$from, $to])->get();
        }

        return view('orders.index', compact('orders'));
    }
    public function getChartData(Request $request)
    {
        try {

            $fromDate = $request->query('fromDate') ?: now()->subMonth()->toDateString();
            $toDate = $request->query('toDate') ?: now()->toDateString();

            if (!\DateTime::createFromFormat('Y-m-d', $fromDate) || !\DateTime::createFromFormat('Y-m-d', $toDate)) {
                throw new \Exception('Định dạng ngày không hợp lệ. Vui lòng sử dụng YYYY-MM-DD.');
            }


            if ($fromDate > $toDate) {
                [$fromDate, $toDate] = [$toDate, $fromDate];
            }


            $orders = DonHang::selectRaw('DATE(created_at) as date, COUNT(id) as total_orders')
                ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();


            $revenue = DonHang::selectRaw('DATE(created_at) as date, SUM(thanhtien) as total_revenue')
                ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $labels = [];
            $currentDate = new \DateTime($fromDate);
            $endDate = new \DateTime($toDate);
            while ($currentDate <= $endDate) {
                $labels[] = $currentDate->format('Y-m-d');
                $currentDate->modify('+1 day');
            }


            $orderData = array_fill(0, count($labels), 0);
            $revenueData = array_fill(0, count($labels), 0);

            foreach ($orders as $order) {
                $index = array_search($order->date, $labels);
                if ($index !== false) {
                    $orderData[$index] = (int) $order->total_orders;
                }
            }

            foreach ($revenue as $rev) {
                $index = array_search($rev->date, $labels);
                if ($index !== false) {
                    $revenueData[$index] = (float) $rev->total_revenue;
                }
            }

            return response()->json([
                'labels' => $labels,
                'orders' => $orderData,
                'revenue' => $revenueData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 422);
        }
    }
    public function destroy($id)
    {
        $donhang = Donhang::findOrFail($id);
        $donhang->delete();
        return redirect()->route('donhang.index')->with('success', 'Xóa đơn hàng thành công!');
    }
    public function updateStatus(Request $request, $id)
    {
        $donhang = Donhang::findOrFail($id);
        $validated = $request->validate([
            'trangthai' => 'required|in:chờ xác nhận,đã xác nhận,đang giao,hoàn thành,đã hủy',
        ]);

        $donhang->update(['trangthai' => $validated['trangthai']]);
        flash()->success('Đơn đã được duyệt thành công!', ['timeout' => 2000]);
        return redirect()->back();
    }
    public function updateTT(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'trangthai' => 'required|in:chưa thanh toán,đã thanh toán',
            ]);

            $thanhtoan = ThanhToan::findOrFail($id);
            $thanhtoan->update(['trangthai' => $validated['trangthai']]);

            flash()->success('Đã cập nhật trạng thái thanh toán!', ['timeout' => 2000]);
        } catch (\Throwable $e) {
            Log::error('Lỗi cập nhật trạng thái: ' . $e->getMessage());
            flash()->error('Cập nhật trạng thái thất bại!', ['timeout' => 3000]);
        }

        return redirect()->back();
    }
}
