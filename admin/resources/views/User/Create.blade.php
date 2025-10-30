@extends('page.layout')
@section('title', 'Tạo người dùng')
@section('content')
    <div class="container mt-4">
        <div class="container  mb-4 p-0">
            <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">
                < Trở lại</a>
                    <div class="container d-flex bg-white shadow-sm rounded align-items-center mt-4 mb-4 p-0">
                        <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                            <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                            <div>
                                <h5 class="text-dark">Thêm người dùng</h5>

                            </div>
                        </div>

                    </div>
        </div>
        <div class="form-container bg-white p-4 shadow rounded">

            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="avatar-container">
                    <div class="container-fluid text-center mb-4">
                        <h5 class="text-dark">Avatar</h5>
                        <input type="file" id="fileInput" name="hinh"
                            class="form-control @error('hinh') is-invalid @enderror" style="display: none;"
                            onchange="previewImage(event)">
                        <img id="avatar" class="img-fluid rounded-circle" src="{{ asset('img-user/_default-user.png') }}"
                            alt="User Avatar" style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                            onclick="document.getElementById('fileInput').click();">
                        <h5 class="text-danger mt-2">
                            @error('hinh')
                                {{ $message }}
                            @enderror
                        </h5>
                        <h5 class="text-dark">Nhấp để chọn ảnh</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Họ và Tên <i class="bi bi-asterisk text-danger"
                                style="font-size: 12px"></i></label>
                        <input type="text" class="form-control @error('hoten') is-invalid @enderror" name="hoten"
                            placeholder="Nhập họ và tên" value="{{ old('hoten') }}">
                        @error('hoten')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Email <i class="bi bi-asterisk text-danger"
                                style="font-size: 12px"></i></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="Nhập email" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Mật khẩu <i class="bi bi-asterisk text-danger"
                                style="font-size: 12px"></i></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Nhập mật khẩu">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Địa chỉ</label>
                        <input type="text" class="form-control" name="diachi" placeholder="Nhập địa chỉ"
                            value="{{ old('diachi') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Số Điện thoại</label>
                        <input type="text" class="form-control @error('sodienthoai') is-invalid @enderror"
                            name="sodienthoai" placeholder="Nhập số điện thoại" value="{{ old('sodienthoai') }}">
                        @error('sodienthoai')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Giới Tính</label>
                        <select class="form-select" name="gioitinh">
                            <option value="" selected>Chọn giới tính</option>
                            <option value="0" {{ old('gioitinh') == '0' ? 'selected' : '' }}>Nữ</option>
                            <option value="1" {{ old('gioitinh') == '1' ? 'selected' : '' }}>Nam</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Quyền <i class="bi bi-asterisk text-danger"
                                style="font-size: 12px"></i></label>
                        <select class="form-select @error('quyen') is-invalid @enderror" name="quyen">
                            <option value="" selected>Chọn quyền truy cập</option>
                            <option value="0" {{ old('quyen') == '0' ? 'selected' : '' }}>Customer</option>
                            <option value="1" {{ old('quyen') == '1' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('quyen')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">
                        < Trở lại</a>
                            <button type="submit" class="btn btn-primary">💾 Tạo mới</button>
                </div>
            </form>

        </div>
    </div>
@endsection

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('avatar');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
