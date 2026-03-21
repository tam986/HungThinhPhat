@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Đăng nhập')
@section('content')
    <div class="container bg-light rounded shadow-sm mt-5" style="max-width: 400px">
        <div class="container p-5 text-center"><img src="./logo/HungThinh.png" class="img-fluid "
                style="width:150px; height:auto" alt="">
        </div>
        <h3 class="text-center mb-4">Đăng Nhập</h3>

        {{-- Hiển thị thông báo thành công hoặc lỗi --}}
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

        {{-- Form đăng nhập --}}
        <form method="POST" action="{{ route('login.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <div class="mt-3 text-center">
            <span>Bạn chưa có tài khoản? <a href="{{ route('register.form') }}">Đăng ký</a></span>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('data')) {
                $.post('/yeuthich/dong-bo', {
                    Yeuthich: JSON.parse(localStorage.getItem('data'))
                }, function(res) {
                    localStorage.removeItem('data');
                    console.log('Đã đồng bộ danh sách yêu thích lên server');
                });
            }
        });
    </script>
@endsection
