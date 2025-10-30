<?php

namespace App\Http\Controllers;

use App\Models\Bienthe;
use App\Models\Donhang;
use App\Models\Donhangchitiet;
use App\Models\Magiamgia;
use App\Models\ThanhToan; 
use App\Utilities\VNPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
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

        return view('Donhang', compact('cart', 'tongTien', 'tienGiam', 'tienVC', 'thanhTien', 'tongSoLuong', 'hesoGiamGia', 'appliedCoupon', 'couponMessage'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:pay_later,online_payment',
        ]);

        $user = Auth::user();
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống.');
        }

        $tongTien = 0;
        $tongSoLuong = 0;
        $tenSanPhamTong = [];
        foreach ($cart as $item) {
            $gia = isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'] ? $item['giakm'] : $item['gia'];
            $thanhTien = $gia * $item['soluong'];
            $tongTien += $thanhTien;
            $tongSoLuong += $item['soluong'];
            $tenSanPhamTong[] = $item['tensp'] . ' x ' . $item['soluong'];
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
        $idGiamGia = null;
        if ($coupon && isset($coupon['magiamgia'])) {
            $dbCoupon = Magiamgia::where('magiamgia', $coupon['magiamgia'])
                ->where('trangthai', 0)
                ->where('thoidiemketthuc', '>=', now())
                ->first();

            if ($dbCoupon && $dbCoupon->hesogiamgia <= $hesoGiamGia) {
                $hesoGiamGia = $dbCoupon->hesogiamgia;
                $idGiamGia = $dbCoupon->id;
            }
        }

        $tienGiam = $tongTien * ($hesoGiamGia / 100);
        $tienVC = session('shipping_fee', 15000);
        $thanhTien = $tongTien - $tienGiam + $tienVC;

        $order = Donhang::create([
            'id_user' => $user->id,
            'phone' => $request->phone,
            'tennguoinhan' => $request->tennguoinhan,
            'tongtien' => $tongTien,
            'sotiengiam' => $tienGiam,
            'thanhtien' => $thanhTien,
            'email' => $request->email,
            'diachi' => $request->diachi,
            'tienvc' => $tienVC,
            'trangthai' => 'Chờ xác nhận',
            'id_giamgia' => $idGiamGia,
            'ghichu' => $request->ghichu,
        ]);
       

        foreach ($cart as $item) {
            Donhangchitiet::create([
                'id_donhang' => $order->id,
                'id_bienthe' => $item['id_bienthe'],
                'soluong' => $item['soluong'],
                'gia' => isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'] ? $item['giakm'] : $item['gia'],
            ]);

            BienThe::where('id', $item['id_bienthe'])->decrement('soluong', $item['soluong']);
        }

        // Thêm ThanhToan::create
        ThanhToan::create([
            'id_donhang' => $order->id,
            'phuongthucthanhtoan' => $request->payment_type,
            'magiaodich' => null,
            'trangthai' => 'chưa thanh toán',
            'sotienthanhtoan' => $thanhTien,
        ]);
        if ($request->payment_type == 'pay_later') {
            Session::forget(['cart', 'coupon', 'shipping_fee']);

            return redirect()->route('checkout.result')
                ->with('notification', 'Success! You will pay on delivery. Please check your email.');
        }

        if ($request->payment_type == 'online_payment') {
            Session::put('pending_order_id', $order->id);

            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id,
                'vnp_OrderInfo' => 'Thanh toán đơn hàng #' . $order->id,
                'vnp_Amount' => $thanhTien,
            ]);

            return redirect()->to($data_url);
        }

        $order->delete();
        return back()->with('error', 'Phương thức thanh toán không hợp lệ.');
    }

    public function vnPayCheck(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');
        $vnp_Amount = $request->get('vnp_Amount');

        $orderId = Session::get('pending_order_id');

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

                Session::forget(['cart', 'coupon', 'shipping_fee', 'pending_order_id']);
                return redirect()->route('checkout.result')->with('notification', 'Thanh toán thành công!');
            } else {
                if ($orderId) {
                    ThanhToan::where('id_donhang', $orderId)->delete();
                    Donhang::where('id', $orderId)->delete();
                    Session::forget('pending_order_id');
                }
                return redirect()->route('checkout.result')->with('error', 'Thanh toán thất bại!');
            }
        }

        return redirect()->route('checkout.result')->with('error', 'Không nhận được phản hồi từ VNPay.');
    }

    public function result(Request $request)
    {
        if (session('notification')) {
            return view('Checkout', ['message' => session('notification'), 'status' => 'success']);
        } elseif (session('error')) {
            return view('Checkout', ['message' => session('error'), 'status' => 'error']);
        }

        return view('Checkout', ['message' => 'Không có thông tin kết quả thanh toán.', 'status' => 'info']);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $donHang = DonHang::findOrFail($id);
        $newStatus = $request->input('trangthai');

        if ($newStatus === 'hoàn thành') {
            $thanhToan = ThanhToan::where('id_donhang', $donHang->id)->first();

            if (!$thanhToan || $thanhToan->trangthai !== 'đã thanh toán') {
                return back()->with('error', 'Không thể cập nhật trạng thái đơn hàng là "hoàn thành" vì trạng thái thanh toán không phải là "đã thanh toán".');
            }
        }

        $donHang->update(['trangthai' => $newStatus]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}