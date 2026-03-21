@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Thông tin cá nhân')
@section('subtitle_url')
    {{ route('profile.profileUser') }}
@endsection
@section('content')
    <div class="container-fluid bg-light rounded border-0 shadow-sm">
        <div class="row rounded border-0">
            <!-- Sidebar -->
            <nav class="col-md-3 col-12 d-md-block sidebar collapse rounded border-0 shadow-sm" id="sidebarMenu">
                <div class="p-3">
                    <div class="">
                        @if (Auth::check())
                            <h5 class="mb-4" style="">{{ Auth::user()->hoten }}</h5>
                        @else
                            <h5 class="mb-4">Xin chào, khách hàng</h5>
                        @endif

                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item "><a class="nav-link sidebar-nav-link"
                                href="{{ route('profile.profileUser') }}"><i class="bi bi-person-fill fs-2"></i> Thông tin
                                tài
                                khoản</a></li>

                        <li class="nav-item"><a class="nav-link  sidebar-nav-link" href="{{ route('profile.order') }}"><i
                                    class="bi bi-cart-fill fs-2"></i> Quản lý đơn
                                hàng</a></li>
                        <li class="nav-item"><a class="nav-link sidebar-nav-link" href="{{ route('profile.product') }}"><i
                                    class="bi bi-person-heart fs-2"></i> Sản
                                phẩm
                                yêu thích</a></li>
                        <li class="nav-item"><a class="nav-link sidebar-nav-link"
                                href="{{ route('profile.showVerifyMail') }}"><i class="bi bi-gear-fill fs-2"></i> Thay đổi
                                mật
                                khẩu</a></li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-nav-link" href="{{ route('logout') }}"><i
                                    class="bi bi-box-arrow-right fs-2"></i> Đăng
                                xuất</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-12 ms-sm-auto px-md-4 rounded border-0 shadow-sm">
                <!-- Toggle button on mobile -->
                <button class="btn btn-outline-secondary d-md-none mt-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebarMenu">
                    ☰ Menu
                </button>
                <div class="container-fluid mt-4">
                    @yield('profile_content')
                </div>
            </main>
        </div>
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

    .sidebar .nav-link {
        position: relative;
        color: #555;
        line-height: 2.2rem;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover {
        color: #fff;
        /* Chữ chuyển sang màu đen khi hover */
    }

    .sidebar .nav-link:hover::before {
        content: '|';
        color: #fe9705;
        /* Màu cam */
        position: absolute;
        left: -15px;
        /* Điều chỉnh khoảng cách từ trước chữ */
        font-weight: bold;
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

    .nav-item .active {
        color: red;
    }

    .nav-item:hover a {
        background-color: #fe9705;
        border-radius: 50px;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }
</style>
@section('scripts')
    <script>
        $(document).ready(function() {
            const current = window.location.href;
            $('.sidebar-nav-link').each(function() {
                if (this.href === current) {
                    $('.sidebar-nav-link').removeClass('active');
                    $(this).addClass('active');
                }
            });
        });
    </script>
@endsection
