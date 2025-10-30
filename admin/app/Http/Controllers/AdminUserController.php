<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        return view('User', compact('users'));
    }
    public function create()
    {
        return view('User.Create');
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hoten' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'sodienthoai' => 'required|digits_between:9,11|numeric',
            'diachi' => 'nullable|string',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gioitinh' => 'nullable|integer',
            'quyen' => 'nullable|integer',
        ]);

        if ($request->hasFile('hinh')) {
            $validatedData['hinh'] = $request->file('hinh')->store('uploads/img-user', 'public');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        flash()->success('Người dùng đã được tạo thành công!', ['timeout' => 2000]);

        return redirect()->route('user.index');
    }




    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('User.Detail', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        return view('User.Update', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'hoten' => 'nullable|string',
            'email' => 'nullable|email',
            'sodienthoai' => 'nullable|string|max:11',
            'diachi' => 'nullable|string',
            'hinh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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



        $imagePath = null;
        if ($request->hasFile('hinh')) {
            $imagePath = $request->file('hinh')->store('uploads/img-user', 'public');
            $validatedData['hinh'] = $imagePath;
            $user->hinh = $imagePath;
        }
        $user->save();
        return redirect()->route('user.detail', $id)->with('success', 'Sửa người dùng thành công');
    }
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'quyen' => 'required|in:0,1'
        ]);

        $user->update(['quyen' => $validated['quyen']]);
        flash()->success('Người dùng đã được tạo thành công!', ['timeout' => 2000]);
        return redirect()->back();
    }

    public function destroy(string $id)
    {

        User::destroy($id);

        return redirect()->route('user.index')->with('success', 'Người dùng đã bị xóa vĩnh viễn.');
    }
    public function profileUser($id)
    {
        $user = Auth::user();
        return view('Profile', compact('user'));
    }
}
