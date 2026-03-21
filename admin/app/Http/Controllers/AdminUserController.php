<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class AdminUserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $role = $request->query('role');
        $query = User::query();
        if ($search) {
            $query->where('hoten', 'like', '%' . $search . '%');
        }
        if ($sort === 'latest') {
            $query->orderBy('id', 'desc');
        }
        if ($sort === 'az') {
            $query->orderBy('hoten', 'asc');
        } elseif ($sort === 'za') {
            $query->orderBy('hoten', 'desc');
        }
        if ($role !== null) {
            $query->where('quyen', $role);
        }
        $users = $query->paginate(10);
        
        $users->getCollection()->transform(function ($user) {
            $user->hinh_url = $user->hinh ? Storage::url($user->hinh) : null;
            return $user;
        });

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'sort', 'role'])
        ]);
    }
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hoten' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'sodienthoai' => 'required|digits_between:9,11|numeric',
            'diachi' => 'nullable|string',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
            'gioitinh' => 'nullable|integer',
            'quyen' => 'nullable|integer',
        ]);

        if ($request->hasFile('hinh')) {
            $validatedData['hinh'] = $request->file('hinh')->store('uploads/img-user', 'public');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('user.index')->with('success', 'Người dùng đã được tạo thành công!');
    }

    public function detail(string $id)
    {
        $user = User::findOrFail($id);
        $user->hinh_url = $user->hinh ? Storage::url($user->hinh) : null;
        return Inertia::render('Users/Detail', ['user' => $user]);
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $user->hinh_url = $user->hinh ? Storage::url($user->hinh) : null;
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'hoten' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'sodienthoai' => 'nullable|string|max:11',
            'diachi' => 'nullable|string',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
            'gioitinh' => 'nullable|integer',
            'quyen' => 'nullable|integer',
        ]);

        $user = User::findOrFail($id);

        $user->hoten = $validatedData['hoten'] ?? $user->hoten;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->sodienthoai = $validatedData['sodienthoai'] ?? $user->sodienthoai;
        $user->diachi = $validatedData['diachi'] ?? $user->diachi;
        $user->quyen = $validatedData['quyen'] ?? $user->quyen;
        $user->gioitinh = $validatedData['gioitinh'] ?? $user->gioitinh;

        if ($request->hasFile('hinh')) {
             if ($user->hinh) {
                Storage::disk('public')->delete($user->hinh);
            }
            $user->hinh = $request->file('hinh')->store('uploads/img-user', 'public');
        }
        
        $user->save();
        return redirect()->route('user.detail', $id)->with('success', 'Cập nhật người dùng thành công');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'quyen' => 'required|in:0,1'
        ]);

        $user->update(['quyen' => $validated['quyen']]);
        return redirect()->back()->with('success', 'Cập nhật vai trò thành công!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->hinh) {
            Storage::disk('public')->delete($user->hinh);
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Người dùng đã bị xóa.');
    }

    public function profileUser($id)
    {
        $user = Auth::user();
        $user->hinh_url = $user->hinh ? Storage::url($user->hinh) : null;
        return Inertia::render('Profile', ['user' => $user]);
    }
}
