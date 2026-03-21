<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Bienthe;
use App\Models\Donhang;
use App\Models\Donhangchitiet;
use App\Models\Magiamgia;
use App\Models\Setting;
use App\Models\ThanhToan; 
use App\Utilities\VNPay;
use App\Events\OrderCreated;
use App\Events\OrderStatusChanged;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Giỏ hàng của bạn đang trống.'], 400);
        }

        $tongTien = 0;
        $tongSoLuong = 0;
        foreach ($cart as $item) {
            $gia = isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'] ? $item['giakm'] : $item['gia'];
            $thanhTien = $gia * $item['soluong'];
            $tongTien += $thanhTien;
            $tongSoLuong += $item['soluong'];
        }

        $tienGiam = 0;
        $hesoGiamGia = 0;
        if ($tongTien >= 500000) {
            $hesoGiamGia = 30;
        } elseif ($tongTien >= 400000) {
            $hesoGiamGia = 25;
        } elseif ($tongTien >= 300000) {
            $hesoGiamGia = 20;
        } elseif ($tongTien >= 200000) {
            $hesoGiamGia = 15;
        } elseif ($tongTien >= 100000) {
            $hesoGiamGia = 10;
        }

        $coupon = session('coupon');
        $appliedCoupon = null;
        $couponMessage = 'Không có mã giảm giá';

        if ($coupon && isset($coupon['magiamgia'])) {
            $dbCoupon = Magiamgia::where('magiamgia', $coupon['magiamgia'])
                ->where('trangthai', 0)
                ->where('thoidiemketthuc', '>=', now())
                ->first();

            if ($dbCoupon) {
                if ($dbCoupon->hesogiamgia <= $hesoGiamGia) {
                    $hesoGiamGia = $dbCoupon->hesogiamgia;
                    $appliedCoupon = $dbCoupon;
                    $couponMessage = null;
                } else {
                    $couponMessage = 'Mã giảm giá không đủ điều kiện';
                    Session::forget('coupon');
                }
            } else {
                $couponMessage = 'Mã giảm giá không đủ điều kiện';
                Session::forget('coupon');
            }
        }

        $tienGiam = $tongTien * ($hesoGiamGia / 100);
        $tienVC = session('shipping_fee', 15000);
        $thanhTien = $tongTien - $tienGiam + $tienVC;

        return response()->json(compact('cart', 'tongTien', 'tienGiam', 'tienVC', 'thanhTien', 'tongSoLuong', 'hesoGiamGia', 'appliedCoupon', 'couponMessage'));
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'payment_type' => 'required|in:cod,bankTransfer',
                'id_user'      => 'nullable|integer|exists:users,id',
                'email'        => 'required|email',
                'phone'        => 'required',
                'tennguoinhan' => 'required',
                'diachi'       => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = collect($errors)->flatten()->first();
            return response()->json(['error' => $firstError], 422);
        }

        $idUser = $request->input('id_user');
        $cart = $request->input('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Giỏ hàng trống.'], 400);
        }

        $tongTien = 0;
        $tongSoLuong = 0;
        $tenSanPhamTong = [];
        foreach ($cart as $item) {
            $gia = isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'] ? $item['giakm'] : $item['gia'];
            $thanhTienItem = $gia * $item['soluong'];
            $tongTien += $thanhTienItem;
            $tongSoLuong += $item['soluong'];
            $tenSanPhamTong[] = ($item['tensp'] ?? 'Sản phẩm') . ' x ' . $item['soluong'];
        }

        $tienGiam = 0;
        $hesoGiamGia = 0;
        if ($tongTien >= 500000) {
            $hesoGiamGia = 30;
        } elseif ($tongTien >= 400000) {
            $hesoGiamGia = 25;
        } elseif ($tongTien >= 300000) {
            $hesoGiamGia = 20;
        } elseif ($tongTien >= 200000) {
            $hesoGiamGia = 15;
        } elseif ($tongTien >= 100000) {
            $hesoGiamGia = 10;
        }

        $couponCode = $request->input('coupon_code');
        $idGiamGia = null;
        if ($couponCode) {
            $dbCoupon = Magiamgia::where('magiamgia', $couponCode)
                ->where('trangthai', 0)
                ->where('thoidiemketthuc', '>=', now())
                ->first();

            if ($dbCoupon && $dbCoupon->hesogiamgia <= $hesoGiamGia) {
                $hesoGiamGia = $dbCoupon->hesogiamgia;
                $idGiamGia = $dbCoupon->id;
            }
        }

        $tienGiam = $request->input('voucher_value', $tongTien * ($hesoGiamGia / 100));
        
        $settingVC = Setting::where('key', 'shipping_fee')->first();
        $tienVC = $settingVC ? (float)$settingVC->value : 15000;
        
        $thanhTien = $tongTien - $tienGiam + $tienVC;

        // Generate ma_donhang: HTP-YYYYMMDD-XXXX
        $maDonHang = 'HTP-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
        
        // Đảm bảo mã đơn hàng là duy nhất
        while (Donhang::where('ma_donhang', $maDonHang)->exists()) {
            $maDonHang = 'HTP-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
        }

        $order = Donhang::create([
            'ma_donhang'   => $maDonHang,
            'id_user'      => $idUser,
            'phone'        => $request->phone,
            'tennguoinhan' => $request->tennguoinhan,
            'tongtien'     => $tongTien,
            'sotiengiam'   => $tienGiam,
            'thanhtien'    => $thanhTien,
            'email'        => $request->email,
            'diachi'       => $request->diachi,
            'tienvc'       => $tienVC,
            'trangthai'    => 'Chờ xác nhận',
            'id_giamgia'   => $idGiamGia,
            'ghichu'       => $request->ghichu ?? '',
            'transfer_proof' => $request->transfer_proof,
        ]);

        foreach ($cart as $item) {
            Donhangchitiet::create([
                'id_donhang' => $order->id,
                'id_bienthe' => $item['id_bienthe'],
                'soluong'    => $item['soluong'],
                'gia'        => isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'] ? $item['giakm'] : $item['gia'],
            ]);

            BienThe::where('id', $item['id_bienthe'])->decrement('soluong', $item['soluong']);
        }

        // Thêm ThanhToan::create
        $paymentMapping = [
            'cod' => 'cod',
            'bankTransfer' => 'chuyenkhoan_nganhang'
        ];

        ThanhToan::create([
            'id_donhang'          => $order->id,
            'phuongthucthanhtoan' => $paymentMapping[$request->payment_type],
            'magiaodich'          => null,
            'trangthai'           => 'chưa thanh toán',
            'sotienthanhtoan'     => $thanhTien,
        ]);

        // Broadcast event realtime to admin
        event(new OrderCreated($order));

        // Send Confirmation Email
        try {
            Mail::to($order->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            \Log::error("Failed to send order confirmation email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true, 
            'message' => 'Đặt hàng thành công! Vui lòng kiểm tra email.', 
            'order_id' => $order->id
        ]);
    }



    public function vnPayCheck(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');
        $vnp_Amount = $request->get('vnp_Amount');

        $orderId = $vnp_TxnRef ?? Session::get('pending_order_id');

        if ($vnp_ResponseCode != null) {
            if ($vnp_ResponseCode == '00') {
                // Cập nhật bảng thanhtoan khi thanh toán thành công
                $thanhToan = ThanhToan::where('id_donhang', $orderId)->first();
                if ($thanhToan && $thanhToan->phuongthucthanhtoan === 'online_payment') {
                    $thanhToan->update([
                        'trangthai' => 'đã thanh toán',
                        'magiaodich' => $vnp_TxnRef,
                    ]);
                }

                // Broadcast VNPay Order Success to Admin
                $orderForEvent = Donhang::find($orderId);
                if ($orderForEvent) {
                    event(new OrderCreated($orderForEvent));
                }

                Session::forget(['cart', 'coupon', 'shipping_fee', 'pending_order_id']);
                return response()->json(['success' => true, 'message' => 'Thanh toán thành công!']);
            } else {
                if ($orderId) {
                    ThanhToan::where('id_donhang', $orderId)->delete();
                    Donhang::where('id', $orderId)->delete();
                    Session::forget('pending_order_id');
                }
                return response()->json(['error' => 'Thanh toán thất bại!'], 400);
            }
        }

        return response()->json(['error' => 'Không nhận được phản hồi từ VNPay.'], 400);
    }

    public function result(Request $request)
    {
        return response()->json(['message' => session('notification') ?? session('error') ?? 'Không có thông tin kết quả thanh toán.']);
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('orders/proofs', 'public');
            return response()->json(['success' => true, 'url' => $path]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $donHang = DonHang::findOrFail($id);
        $newStatus = $request->input('trangthai');

        if ($newStatus === 'hoàn thành') {
            $thanhToan = ThanhToan::where('id_donhang', $donHang->id)->first();

            if (!$thanhToan || $thanhToan->trangthai !== 'đã thanh toán') {
                return response()->json(['success' => false, 'message' => 'Không thể cập nhật trạng thái đơn hàng là "hoàn thành" vì trạng thái thanh toán không phải là "đã thanh toán".'], 400);
            }
        }

        $donHang->update(['trangthai' => $newStatus]);

        // Broadcast realtime update to client
        event(new OrderStatusChanged($donHang, $donHang->id_user));

        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công.']);
    }

    public function show($id)
    {
        $order = Donhang::find($id);
        if (!$order) {
            return response()->json(['error' => 'Không tìm thấy đơn hàng.'], 404);
        }
        return response()->json(['success' => true, 'data' => $order]);
    }
}
