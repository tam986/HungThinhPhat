@extends('Profile')
@section('title', 'Trang chủ')
@section('subtitle', 'Đổi mật khẩu')
@section('profile_content')
    <div class="container py-5">
        <div class="container rounded shadow-sm p-2 d-flex align-items-center bg-white mb-4">
            <h4 class="title-profile">Đặt lại mật khẩu</h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profile.sendResetOtp') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required
                    value="{{ old('email') }}">
            </div>
            <button type="submit" class="btn btn-primary w-100">Gửi mã xác thực</button>
        </form>
    </div>
@endsection
