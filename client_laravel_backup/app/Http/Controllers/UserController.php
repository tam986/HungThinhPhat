<?php

namespace App\Http\Controllers;

use App\Models\Donhang;
use App\Models\User;
use App\Models\Yeuthich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getForm()
    {
        return view('pages.Login');
    }
    public function index()
    {
        $info = Auth::user();
        return view('profile.Info', compact('info'));
    }
    public function showOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.home');
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

        return view('profile.MyOrder', compact(
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
            return redirect()->route('client.home');
        }


        $donhang = Donhang::where('id_user', $user->id)->where('id', $id)->firstOrFail();

        if ($donhang->trangthai != 'chờ xác nhận') {
            return redirect()->route('profile.order')->with('error', 'Đơn hàng không thể hủy vì không ở trạng thái chờ xác nhận.');
        }


        $donhang->trangthai = 'hủy';
        $donhang->save();

        return redirect()->route('profile.order')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
    public function showChangePassVerify()
    {
        if (!session('forgot_password_otp')) {
            flash()->error('Vui lòng yêu cầu mã xác thực trước.');
            return redirect()->route('profile.showVerifyMail');
        }

        return view('profile.ResetPass');
    }
    public function showVerifyMail()
    {
        session()->forget(['forgot_password_stage', 'forgot_password_otp_sent', 'forgot_password_user_id', 'forgot_password_otp', 'forgot_password_otp_expires']);
        return view('profile.SentRePassEmail');
    }



    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'hoten' => 'nullable|string',
            'email' => 'nullable|email',
            'sodienthoai' => 'nullable|string|max:11',
            'diachi' => 'nullable|string',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        flash()->success('Sửa thông tin người dùng thành công!');
        return redirect()->route('profile.profileUser');
    }
}