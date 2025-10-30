<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Bienthe;
use App\Models\Sanpham;
use App\Models\Magiamgia;
use Illuminate\Support\Facades\Auth;

class GiohangController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        if (!is_array($cart)) {
            $cart = [];
            Session::put('cart', $cart);
        }

        foreach ($cart as $key => &$item) {
            if (!is_array($item) || !isset($item['id_bienthe'], $item['subtotal'])) {
                unset($cart[$key]);
                continue;
            }

            $bienthe = Bienthe::find($item['id_bienthe']);
            if ($bienthe) {
                $item['soluong_tonkho'] = $bienthe->soluong;
            } else {
                unset($cart[$key]);
            }
        }
        Session::put('cart', $cart);

        $coupons = Magiamgia::where('trangthai', 0)
            ->where('thoidiemketthuc', '>=', now())
            ->get();

        $totalItems = count($cart);
        $totalPrice = array_sum(array_column($cart, 'subtotal'));

        $shipping = Session::get('shipping_fee', 8000);

        return view('pages.Giohang', compact('cart', 'coupons', 'totalItems', 'totalPrice', 'shipping'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1'
        ]);

        $bienthe = Bienthe::with(['sanpham', 'nhanbanh', 'khoiluong'])
            ->findOrFail($request->id_bienthe);

        $cart = Session::get('cart', []);

        if (!is_array($cart)) {
            $cart = [];
        }

        $currentQuantityInCart = 0;
        foreach ($cart as $item) {
            if (!is_array($item)) {
                continue;
            }
            if ($item['id_bienthe'] == $request->id_bienthe) {
                $currentQuantityInCart = $item['soluong'];
                break;
            }
        }

        $totalQuantity = $currentQuantityInCart + $request->soluong;

        if ($bienthe->soluong < $totalQuantity) {
            return redirect()->back()->with('error', 'Sản phẩm đã đạt mức giới hạn tồn kho trong giỏ hàng của bạn.');
        }

        $checkCart = false;

        foreach ($cart as &$item) {
            if (!is_array($item)) {
                continue;
            }
            if ($item['id_bienthe'] == $request->id_bienthe) {
                $item['soluong'] += $request->soluong;
                $item['subtotal'] = $item['soluong'] * $item['gia'];
                $checkCart = true;
                break;
            }
        }

        if (!$checkCart) {
            $cart[] = [
                'id_bienthe' => $bienthe->id,
                'hinh' => $bienthe->hinh,
                'tensp' => $bienthe->sanpham->tensp,
                'tenNhanBanh' => $bienthe->nhanbanh ? $bienthe->nhanbanh->tenNhanBanh : 'Không có',
                'khoiluong' => $bienthe->khoiluong ? $bienthe->khoiluong->khoiluong : 'Không có',
                'gia' => $bienthe->gia,
                'soluong' => $request->soluong,
                'soluong_tonkho' => $bienthe->soluong,
                'subtotal' => $bienthe->gia * $request->soluong
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function update(Request $request, $id_bienthe)
    {
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'capnhat' => 'required|integer'
        ]);

        $cart = Session::get('cart', []);

        if (!is_array($cart)) {
            $cart = [];
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không hợp lệ.');
        }

        $bienthe = Bienthe::findOrFail($id_bienthe);

        $found = false;
        foreach ($cart as &$item) {
            if (!is_array($item)) {
                continue;
            }
            if ($item['id_bienthe'] == $id_bienthe) {
                $newSoluong = $item['soluong'] + $request->capnhat;
                if ($newSoluong < 1) {
                    $newSoluong = 1;
                }
                if ($bienthe->soluong < $newSoluong) {
                    return redirect()->back()->with('error', 'Số lượng yêu cầu vượt quá tồn kho.');
                }
                $item['soluong'] = $newSoluong;
                $item['subtotal'] = $item['soluong'] * $item['gia'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công.');
    }

    public function destroy($id_bienthe)
    {
        $cart = Session::get('cart', []);

        if (!is_array($cart)) {
            $cart = [];
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không hợp lệ.');
        }

        $cart = array_filter($cart, function ($item) use ($id_bienthe) {
            return is_array($item) && $item['id_bienthe'] != $id_bienthe;
        });

        Session::put('cart', array_values($cart));

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'magiamgia' => 'required|exists:phieugiamgia,magiamgia'
        ]);

        $coupon = Magiamgia::where('magiamgia', $request->magiamgia)
            ->where('trangthai', 0)
            ->where('thoidiemketthuc', '>=', now())
            ->first();

        if (!$coupon) {
            return redirect()->route('cart.index')->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }

        Session::put('coupon', [
            'magiamgia' => $coupon->magiamgia,
            'hesogiamgia' => $coupon->hesogiamgia
        ]);

        return redirect()->route('cart.index')->with('success', 'Áp dụng mã giảm giá thành công.');
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return redirect()->route('cart.index')->with('success', 'Đã hủy bỏ mã giảm giá.');
    }

    public function applyShipping(Request $request)
    {
        $request->validate([
            'shipping' => 'required|in:8000,15000,20000'
        ]);

        $shippingFee = $request->input('shipping');
        Session::put('shipping_fee', $shippingFee);

        return redirect()->route('cart.index')->with('success', 'Phí vận chuyển đã được áp dụng.');
    }
}
