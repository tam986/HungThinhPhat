<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Donhang;
use App\Models\User;
use App\Models\Yeuthich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getForm()
    {
        return response()->json(['message' => 'Login form endpoint']);
    }
    public function index()
    {
        $info = Auth::user();
        return response()->json(compact('info'));
    }
    public function showOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }


        $search = $request->input('search');

        if ($search) {
            $search = str_replace('#MD', '', $search);
            $search = str_replace(['#md', '#MD '], '', trim($search));
        }


        $query = Donhang::where('id_user', $user->id);

        if ($search) {
            $query->where('id', 'like', '%' . $search . '%');
        }

        $orderAll = $query->orderBy('id', 'desc')->get();


        $pendingOrders = (clone $query)->where('trangthai', 'chờ xác nhận')->get();
        $confirmedOrders = (clone $query)->where('trangthai', 'đã xác nhận')->get();
        $shippingOrders = (clone $query)->where('trangthai', 'đang giao')->get();
        $doneOrders = (clone $query)->where('trangthai', 'hoành thành')->get();
        $cancelledOrders = (clone $query)->where('trangthai', 'hủy')->get();

        return response()->json(compact(
            'orderAll',
            'pendingOrders',
            'confirmedOrders',
            'shippingOrders',
            'doneOrders',
            'cancelledOrders',
            'search'
        ));
    }
    public function cancelOrder(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }


        $donhang = Donhang::where('id_user', $user->id)->where('id', $id)->firstOrFail();

        if ($donhang->trangthai != 'chờ xác nhận') {
            return response()->json(['success' => false, 'message' => 'Đơn hàng không thể hủy vì không ở trạng thái chờ xác nhận.'], 400);
        }


        $donhang->trangthai = 'hủy';
        $donhang->save();

        return response()->json(['success' => true, 'message' => 'Đơn hàng đã được hủy thành công.']);
    }
    public function showChangePassVerify()
    {
        if (!session('forgot_password_otp')) {
            return response()->json(['success' => false, 'message' => 'Vui lòng yêu cầu mã xác thực trước.'], 400);
        }

        return response()->json(['success' => true, 'message' => 'Reset password form context']);
    }
    public function showVerifyMail()
    {
        session()->forget(['forgot_password_stage', 'forgot_password_otp_sent', 'forgot_password_user_id', 'forgot_password_otp', 'forgot_password_otp_expires']);
        return response()->json(['success' => true, 'message' => 'Sent RePass Email form context']);
    }



    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'hoten' => 'nullable|string',
            'email' => 'nullable|email',
            'sodienthoai' => 'nullable|string|max:11',
            'diachi' => 'nullable|string',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
            'gioitinh' => 'nullable|integer',
        ]);

     
        $user->hoten = $validatedData['hoten'] ?? $user->hoten;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->sodienthoai = $validatedData['sodienthoai'] ?? $user->sodienthoai;
        $user->diachi = $validatedData['diachi'] ?? $user->diachi;
        $user->gioitinh = $validatedData['gioitinh'] ?? $user->gioitinh;

        if ($request->hasFile('hinh')) {
            $imagePath = $request->file('hinh')->store('uploads/img-user', 'public');
            $validatedData['hinh'] = $imagePath;
            $user->hinh = $imagePath;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Sửa thông tin người dùng thành công!', 'user' => $user]);
    }
}
