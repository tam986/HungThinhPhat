<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

}
