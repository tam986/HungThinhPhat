<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function loginActive(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->update(['last_login' => Carbon::now()]);
            return redirect()->route('dashboard.index')->with('success', 'Bạn đã đăng nhập thành công');
        } else {
            return redirect()->route('login.show')->with('error', 'Tài khoản và mật khẩu không đúng hoặc bạn không phải là admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showUsers()
    {
        // Những user online là những người có login nhưng chưa logout
        $usersOnline = User::whereNotNull('last_login')
                            ->where(function ($query) {
                                $query->whereNull('last_logout')
                                      ->orWhereColumn('last_login', '>', 'last_logout');
                            })
                            ->orderByDesc('last_login')
                            ->get();
    
        // Những user offline là đã logout sau khi login
        $usersOffline = User::whereNotNull('last_logout')
                            ->where(function ($query) {
                                $query->whereNull('last_login')
                                      ->orWhereColumn('last_logout', '>=', 'last_login');
                            })
                            ->orderByDesc('last_logout')
                            ->get();
    
        return view('page.online', compact('usersOnline', 'usersOffline'));
    }

  public function logout(Request $request)
{
    $user = Auth::user();

    if ($user) {
        $user->update([
            'last_logout' => now(),
            'last_login' => null // 👈 xoá login để xác định rõ ràng đã offline
        ]);
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login.show');
}

public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', __($status))
        : back()->withErrors(['email' => __($status)]);
}

public function showResetPasswordForm(Request $request, $token)
{
    return view('auth.reset-password')->with(
        ['token' => $token, 'email' => $request->email]
    );
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login.show')->with('success', __($status))
        : back()->withErrors(['email' => [__($status)]]);
}

public function showRegistrationForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $request->validate([
        'hoten' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Using argon2id to satisfy "not Bcrypt" requirement
    $user = User::create([
        'hoten' => $request->hoten,
        'email' => $request->email,
        'password' => Hash::make($request->password, ['driver' => 'argon2id']),
        'quyen' => 1,
    ]);

    return redirect()->route('login.show')->with('success', 'Tài khoản admin tạm thời đã được tạo (Argon2id).');
}

}
