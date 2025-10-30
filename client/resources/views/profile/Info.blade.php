@extends('Profile')
@section('title', 'Trang chủ')
@section('subtitle', 'Thông tin cá nhân')
@section('subsubtitle', 'Sửa thông tin')
@section('subtitle_url')
    {{ route('profile.profileUser') }}
@endsection
@section('profile_content')
    <div class="container-fluid mt-4 mb-4 ">
        <div class="container rounded shadow-sm p-2 d-flex align-items-center bg-white mb-4">
            <h4 class="title-profile">Edit profile</h4>
        </div>


        <!-- Avatar -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="font-weight:bold;">
            @csrf
            @method('PUT')
            <div class=" mb-4">
                <h5 style="font-weight:bold;">Ảnh đại diện</h5>


                <div class="d-flex gap-4">
                    <div>

                        <input type="file" id="fileInput" name="hinh" class="d-none" onchange="previewImage(event)">
                        <img id="avatar"
                            src="{{ asset('storage/' . Auth::user()->hinh) ?? 'https://via.placeholder.com/100' }}"
                            class="upload-image mb-2" alt="Avatar">

                    </div>
                    <div>
                        <button type="button" class="btn btn-upload btn-outline-secondary btn-lg"
                            onclick="document.getElementById('fileInput').click();">Upload new image</button>
                        <div class="form-text text-muted mt-4" style="font-size: 16px;"><span><i>At least 800×800
                                    px. JPG,
                                    PNG,
                                    GIF allowed.</i></span></div>
                    </div>
                </div>

            </div>

            <!-- Full Name -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Họ tên</label>
                <div class="input-group input-group-lg ">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                    <input type="text" name="hoten" class="form-control" placeholder="{{ Auth::user()->hoten }}"
                        aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Giới tính</label>

                <select class="form-select" name="gioitinh" aria-label="Default select example">
                    <option value="1" {{ Auth::user()->gioitinh == 1 ? 'selected' : '' }}>Nam</option>
                    <option value="0" {{ Auth::user()->gioitinh == 0 ? 'selected' : '' }}>Nữ</option>
                </select>

            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label text-dark">Số Điện thoại</label>
                <input type="text" class="form-control" name="sodienthoai" placeholder="{{ Auth::user()->sodienthoai }}"
                    value="{{ Auth::user()->sodienthoai }}" oninput="this.value = this.value.replace(/[^0-9+]/g, '');">
            </div>

            <!-- Email (disabled) -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label class="form-label text-dark">Địa chỉ</label>
                <input type="text" class="form-control" name="diachi" placeholder="" value="{{ Auth::user()->diachi }}">
            </div>

            <!-- Save Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
@endsection
<style>
    .title-profile {
        position: relative;
        padding-left: 20px;
    }

    .title-profile::before {
        position: absolute;
        content: '| ';
        font-size: 24px;
        top: 0;
        left: 0;
        line-height: 24px;
        font-weight: 800;
        color: #fe9705;
    }


    .order-empty {
        text-align: center;
        padding: 50px 0;
    }

    .order-empty img {
        max-width: 100px;
        margin-bottom: 20px;
    }

    .form-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #1e1e1e;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .form-control,
    .form-select {
        background-color: #2a2a2a;
        border: none;
        color: #fff;
    }

    .form-control:disabled {
        background-color: #3c3c3c;
    }

    .form-control::placeholder {
        color: #aaa;
    }

    .upload-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn-upload {
        background-color: #2a2a2a;
        color: #fff;
        border: 1px solid #444;
    }

    .btn-upload:hover {
        background-color: #3c3c3c;
    }

    .btn-primary {
        background-color: #3b82f6;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }
</style>
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
