@extends('layouts.layout')

@section('content')
    <div class="container p-4 bg-light rounded shadow" style="max-width: 400px; margin-top: 100px;">
        {{-- Hiển thị thông báo thành công hoặc lỗi --}}
        <h2 class="text-center">Đăng ký</h2>
        <div class="container text-center mb-3">
            <img src="./logo/HungThinh.png" alt="Logo" class="img-fluid mb-2"
                style="width: 200px; height: 200px;">

        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('register.form') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" class="form-control mb-2" value="{{ old('email') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <input type="text" name="hoten" placeholder="Họ tên" class="form-control mb-2" value="{{ old('hoten') }}">
            @error('hoten')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <input type="password" name="password" placeholder="Mật khẩu" class="form-control mb-2">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <input type="password" name="password_confirm" placeholder="Xác nhận mật khẩu" class="form-control mb-2">
            @error('password_confirm')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </form>
    </div>
@endsection
