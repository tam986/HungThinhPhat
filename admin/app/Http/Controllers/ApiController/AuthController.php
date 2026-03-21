<?php

namespace App\Http\Controllers\ApiController;

use App\Mail\VerifyCodeMail;
use App\Models\User;
use App\Models\Yeuthich;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function resendOtp()
    {
        $data = session('register_data');
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Thông tin đăng ký không tồn tại.'], 400);
        }

        $code = rand(100000, 999999);
        $expireTime = now()->addMinutes(5);

        session([
            'register_otp' => $code,
            'register_otp_expires' => $expireTime,
        ]);

        Mail::to($data['email'])->send(new VerifyCodeMail($code, $expireTime));
        return response()->json(['success' => true, 'message' => 'Mã xác thực mới đã được gửi.']);
    }

    public function registerForm()
    {
        return response()->json(['message' => 'Register form endpoint']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'hoten' => 'required|string|max:50',
            'password' => 'required|string|min:6|max:20',
            'password_confirm' => 'required|same:password',
        ]);

        $code = rand(100000, 999999);
        $expireTime = now()->addMinutes(5);

        session([
            'register_data' => [
                'email' => $request->email,
                'hoten' => $request->hoten,
                'password' => bcrypt($request->password),
            ],
            'register_otp' => $code,
            'register_otp_expires' => $expireTime
        ]);

        Mail::to($request->email)->send(new VerifyCodeMail($code, $expireTime));
        return response()->json(['success' => true, 'message' => 'Mã xác thực đã được gửi đến email']);
    }

    public function showVerifyForm()
    {
        $expireTime = Carbon::now()->addMinutes(5);
        return response()->json(['message' => 'Show Verify Form endpoint', 'expireTime' => $expireTime]);
    }

    public function handleVerify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6'
        ]);

        if ($request->otp_code != session('register_otp')) {
            return response()->json(['success' => false, 'message' => 'Mã OTP không đúng'], 400);
        }

        $data = session('register_data');
        $user = User::create([
            'email' => $data['email'],
            'hoten' => $data['hoten'],
            'password' => $data['password'],
        ]);

        Auth::login($user);

        session()->forget(['register_data', 'register_otp']);
        return response()->json(['success' => true, 'message' => 'Đăng ký và đăng nhập thành công!', 'user' => $user]);
    }

    public function loginForm()
    {
        return response()->json(['message' => 'Login form endpoint']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $sessionWishlist = Session::pull('yeuthich', []);
            foreach ($sessionWishlist as $item) {
                if (!isset($item['id_bienthe'])) {
                    continue;
                }

                Yeuthich::firstOrCreate([
                    'id_user' => $user->id,
                    'id_bienthe' => $item['id_bienthe'],
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Đăng nhập thành công!', 'user' => $user]);
        }

        return response()->json(['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'], 401);
    }

    // đổi mật khẩu
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Tạo OTP
        $otp = rand(100000, 999999);
        $expireTime = now()->addMinutes(5);

        // Lưu OTP và dữ liệu người dùng vào session
        session([
            'forgot_password_otp' => $otp,
            'forgot_password_otp_expires' => $expireTime,
            'forgot_password_user_id' => $user->id,
        ]);

        // Gửi OTP qua email
        Mail::to($user->email)->send(new VerifyCodeMail($otp, $expireTime));

        return response()->json(['success' => true, 'message' => 'Mã xác thực đã được gửi đến email của bạn.']);
    }
    // gửi lại mã xác nhận
    public function resendResetOtp()
    {
        if (!session('forgot_password_user_id')) {
            return response()->json(['success' => false, 'message' => 'Phiên xác thực không tồn tại.'], 400);
        }

        $user = User::find(session('forgot_password_user_id'));
        if (!$user) {
            session()->forget(['forgot_password_otp', 'forgot_password_otp_expires', 'forgot_password_user_id']);
            return response()->json(['success' => false, 'message' => 'Người dùng không tồn tại.'], 400);
        }

        // Tạo OTP mới
        $otp = rand(100000, 999999);
        $expireTime = now()->addMinutes(5);

        session([
            'forgot_password_otp' => $otp,
            'forgot_password_otp_expires' => $expireTime,
        ]);

        // Gửi OTP qua email
        Mail::to($user->email)->send(new VerifyCodeMail($otp, $expireTime));
        return response()->json(['success' => true, 'message' => 'Mã xác thực mới đã được gửi.']);
    }
    public function submitResetPass(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'otp_code.required' => 'Vui lòng nhập mã xác thực.',
            'otp_code.digits' => 'Mã xác thực phải là 6 chữ số.',
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);


        if (!session('forgot_password_otp') || !session('forgot_password_user_id')) {
            return response()->json(['success' => false, 'message' => 'Phiên xác thực đã hết hạn.'], 400);
        }


        if ($request->otp_code != session('forgot_password_otp')) {
            return response()->json(['success' => false, 'message' => 'Mã xác thực không đúng.'], 400);
        }

        if (Carbon::now()->greaterThan(session('forgot_password_otp_expires'))) {
            session()->forget(['forgot_password_otp', 'forgot_password_otp_expires', 'forgot_password_user_id']);
            return response()->json(['success' => false, 'message' => 'Mã xác thực đã hết hạn.'], 400);
        }


        $user = User::find(session('forgot_password_user_id'));
        if (!$user) {
            session()->forget(['forgot_password_otp', 'forgot_password_otp_expires', 'forgot_password_user_id']);
            return response()->json(['success' => false, 'message' => 'Người dùng không tồn tại.'], 400);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Mật khẩu cũ không đúng.'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        session()->forget(['forgot_password_otp', 'forgot_password_otp_expires', 'forgot_password_user_id']);

        Auth::logout();
        session()->regenerateToken();
        return response()->json(['success' => true, 'message' => 'Bạn đã đăng xuất thành công!']);
    }

    public function logout()
    {
        try {
            Auth::logout();
            session()->flush();
            session()->regenerateToken();
            return response()->json(['success' => true, 'message' => 'Bạn đã đăng xuất thành công!']);
        } catch (\Throwable $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi đăng xuất!'], 500);
        }
    }
}
