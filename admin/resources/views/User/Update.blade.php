@extends('page.layout')
@section('title', 'Chỉnh sửa người dùng')
@section('content')
    <div class="container mt-4">
        <div class="container mb-4 p-0">
            <button type="button" class="btn btn-secondary me-2">
                < Trở lại</button>
                    <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                        <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                        <div>
                            <h5>Chỉnh sửa người dùng</h5>
                        </div>

                    </div>
        </div>
        <div class="form-container bg-white p-4 shadow rounded">



            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="avatar-container">
                    <div class="container-fluid text-center mb-4">
                        <h5 class="text-dark">Avatar</h5>


                        <input type="file" id="fileInput" name="hinh" class="form-control" style="display: none;"
                            onchange="previewImage(event)">

                        <img id="avatar" class="img-fluid rounded rounded-circle"
                            src="{{ $user->hinh ? asset('storage/uploads' . $user->hinh) : asset('img-user/_default-user.png') }}"
                            alt="User Avatar" style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                            onclick="document.getElementById('fileInput').click();">

                        <h5 class="text-dark">Nhấp để chọn ảnh</h5>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label  text-dark">Họ và Tên</label>
                        <input type="text" class="form-control " name="hoten" placeholder="họ và tên"
                            value="{{ $user->hoten }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label  text-dark">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                            placeholder="Email">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label  text-dark">Password</label>
                        <input type="password" class="form-control" value="{{ $user->password }}" placeholder="Password"
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3  text-dark">
                        <label class="form-label text-dark">Địa chỉ</label>
                        <input type="text" class="form-control" name="diachi" placeholder=""
                            value="{{ $user->diachi }}">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Số Điện thoại</label>
                        <input type="text" class="form-control" name="sodienthoai" placeholder="thêm số điện thoại "
                            value="{{ $user->sodienthoai }}" oninput="this.value = this.value.replace(/[^0-9+]/g, '');">>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Giới Tính</label>

                        <select class="form-select" name="gioitinh" aria-label="Default select example">
                            <option value="1" {{ $user->gioitinh == 1 ? 'selected' : '' }}>Nam</option>
                            <option value="0" {{ $user->gioitinh == 0 ? 'selected' : '' }}>Nữ</option>
                        </select>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Quyền</label>
                        <select class="form-select" name="quyen" aria-label="Default select example">
                            <option value="0" {{ $user->quyen == 0 ? 'selected' : '' }}>Customer</option>
                            <option value="1" {{ $user->quyen == 1 ? 'selected' : '' }}>Admin</option>
                        </select>

                    </div>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">
                        < Trở lại</a>
                            <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger me-2"> ✘ Delete</a>
                            <button type="submit" class="btn btn-primary">💾 Edit</button>
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
