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

        @if (!session('forgot_password_otp'))
            <div class="alert alert-warning">
                Vui lòng yêu cầu mã xác thực trước khi tiếp tục.
                <a href="{{ route('profile.showVerifyMail') }}" class="alert-link">Quay lại</a>
            </div>
        @else
            <form action="{{ route('profile.submitResetPass') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="otp_code" class="form-label">Mã xác thực</label>
                    <input type="text" name="otp_code" id="otp_code" class="form-control" placeholder="Nhập mã xác thực"
                        required>
                    <small class="text-muted">Mã đã được gửi đến email của bạn</small>
                </div>

                <div class="mb-3">
                    <label for="old_password" class="form-label">Mật khẩu cũ</label>
                    <input type="password" name="old_password" id="old_password" class="form-control"
                        placeholder="Mật khẩu cũ" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" name="new_password" id="new_password" class="form-control"
                        placeholder="Mật khẩu mới" required>
                    <small class="text-muted">Tối thiểu 8 ký tự</small>
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        class="form-control" placeholder="Xác nhận mật khẩu mới" required>
                    <small class="text-muted">Tối thiểu 8 ký tự</small>
                </div>

                <div class="d-flex gap-2 justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary px-4 py-2">Đổi mật khẩu</button>

                </div>
            </form>
            <div class="d-flex gap-2 justify-content-end align-items-center">
                <form action="{{ route('profile.resendResetOtp') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link">Gửi lại mã xác thực</button>
                </form>

            </div>
        @endif
    </div>
@endsection
