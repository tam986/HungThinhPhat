@extends('page.layout')
@section('title', 'Profile')
@section('content')
    @extends('page.layout')
@section('title', 'Chi tiết người dùng')
@section('content')
    <div class="container mt-4">
        <button type="button" class="btn btn-secondary me-2">
            < Trở lại</button>
                <div class="container d-flex bg-white shadow-sm rounded align-items-center mt-4 mb-4 p-0">
                    <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                        <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                        <div>
                            <h5 class="text-dark">Thông tin chi tiết</h5>
                        </div>
                    </div>

                </div>

                <div class="form-container bg-white p-4 shadow rounded mb-4">

                    <div class="avatar-container">
                        <div class="container-fluid">
                            <h5 class="text-dark">Avatar</h5>
                            <img id="avatar" class="img-fluid rounded rounded-circle"
                                src="{{ $user->hinh ? asset('uploads/' . $user->hinh) : asset('img-user/_default-user.png') }}"
                                alt="User Avatar" style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                onclick="document.getElementById('fileInput').click();">

                        </div>

                    </div>

                    <form>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label  text-dark">Họ và Tên</label>
                                <input type="text" class="form-control " name="hoten" placeholder="họ và tên"
                                    value="{{ $user->hoten }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label  text-dark">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                    placeholder="Email" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label  text-dark">Password</label>
                                <input type="password" class="form-control" value="{{ $user->password }}"
                                    placeholder="Password" disabled>
                            </div>
                            <div class="col-md-6 mb-3  text-dark">
                                <label class="form-label text-dark">Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="" value="{{ $user->diachi }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark">Số Điện thoại</label>
                                <input type="text" class="form-control" name="sodienthoai" placeholder=""
                                    value="{{ $user->sodienthoai }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark">Giới Tính</label>
                                <input type="text" class="form-control" name="gioitinh"
                                    value="{{ $user->gioitinh == 1 ? 'Nam' : 'Nữ' }}" placeholder="Nam" disabled>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark">Quyền</label>

                                <input type="text" class="form-control" name="gioitinh"
                                    value="{{ $user->quyen == 1 ? 'Admin' : 'Customer' }}" placeholder="Admin" disabled>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">
                                < Trở lại</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-warning">Xóa mềm</button>
                                    </form>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">💾 Edit</a>
                        </div>

                    </form>
                </div>
    </div>
@endsection

@endsection
