<?php

namespace App\Http\Controllers\ApiController;

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

        return response()->json(compact('cart', 'coupons', 'totalItems', 'totalPrice', 'shipping'));
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
            return response()->json(['error' => 'Sản phẩm đã đạt mức giới hạn tồn kho trong giỏ hàng của bạn.'], 400);
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

        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.', 'cart' => $cart]);
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
            return response()->json(['success' => false, 'message' => 'Giỏ hàng không hợp lệ.'], 400);
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
                    return response()->json(['success' => false, 'message' => 'Số lượng yêu cầu vượt quá tồn kho.'], 400);
                }
                $item['soluong'] = $newSoluong;
                $item['subtotal'] = $item['soluong'] * $item['gia'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Cập nhật số lượng thành công.', 'cart' => $cart]);
    }

    public function destroy($id_bienthe)
    {
        $cart = Session::get('cart', []);

        if (!is_array($cart)) {
            $cart = [];
            Session::put('cart', $cart);
            return response()->json(['success' => false, 'message' => 'Giỏ hàng không hợp lệ.'], 400);
        }

        $cart = array_filter($cart, function ($item) use ($id_bienthe) {
            return is_array($item) && $item['id_bienthe'] != $id_bienthe;
        });

        Session::put('cart', array_values($cart));

        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.', 'cart' => array_values($cart)]);
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
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'], 400);
        }

        Session::put('coupon', [
            'magiamgia' => $coupon->magiamgia,
            'hesogiamgia' => $coupon->hesogiamgia
        ]);

        return response()->json(['success' => true, 'message' => 'Áp dụng mã giảm giá thành công.']);
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return response()->json(['success' => true, 'message' => 'Đã hủy bỏ mã giảm giá.']);
    }

    public function applyShipping(Request $request)
    {
        $request->validate([
            'shipping' => 'required|in:8000,15000,20000'
        ]);

        $shippingFee = $request->input('shipping');
        Session::put('shipping_fee', $shippingFee);

        return response()->json(['success' => true, 'message' => 'Phí vận chuyển đã được áp dụng.']);
    }

    /**
     * Validate the client-side cart items against the database stock realtime.
     */
    public function validateCartStock(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id_bienthe' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $items = $request->input('items');
        $bientheIds = array_column($items, 'id_bienthe');
        
        $bienthes = Bienthe::whereIn('id', $bientheIds)->get()->keyBy('id');

        $result = [];
        $hasErrors = false;

        foreach ($items as $item) {
            $id = $item['id_bienthe'];
            $requestedQty = $item['quantity'];
            
            if (!$bienthes->has($id)) {
                $result[] = [
                    'id_bienthe' => $id,
                    'status' => 'not_found',
                    'available' => 0,
                    'requested' => $requestedQty
                ];
                $hasErrors = true;
                continue;
            }

            $bienthe = $bienthes->get($id);
            $availableQty = $bienthe->soluong;

            if ($availableQty == 0) {
                $result[] = [
                    'id_bienthe' => $id,
                    'status' => 'out_of_stock',
                    'available' => 0,
                    'requested' => $requestedQty
                ];
                $hasErrors = true;
            } elseif ($availableQty < $requestedQty) {
                $result[] = [
                    'id_bienthe' => $id,
                    'status' => 'not_enough_stock',
                    'available' => $availableQty,
                    'requested' => $requestedQty
                ];
                $hasErrors = true;
            } else {
                $result[] = [
                    'id_bienthe' => $id,
                    'status' => 'in_stock',
                    'available' => $availableQty,
                    'requested' => $requestedQty
                ];
            }
        }

        return response()->json([
            'success' => !$hasErrors,
            'validation' => $result
        ]);
    }
}
