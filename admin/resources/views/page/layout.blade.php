<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('logo/HungThinh.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
    .sidebar {
        width: 20%;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background-color: #212529;
        overflow-y: auto;
        padding: 15px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        padding: 10px 15px;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
        color: black;
    }

    .nav-link:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .collapse .nav-link {
        padding-left: 30px;
    }

    @media (min-width: 768px) {
        .sidebar {
            width: 80%;
        }

        #main {
            width: 100%;
            margin: 0;
        }
    }

    @media(min-width: 1024px) {
        #main {
            width: 80%;
            margin-left: 20%;
        }
    }
</style>

<body class="bg-white text-light">
    <section class="d-flex flex-column m-0 p-0" style="width:100%; height: 100%;">
        <div class="d-none d-lg-block" style="width:20%;height:100%;position:fixed;">
            @include('page.sidebar')
        </div>
        <main id="main" class="container-fluid p-0" style="background: #f5f5f5">
            <div
                class="container-fluid p-2 bg-white shadow-sm text-light d-flex justify-content-between align-items-center">
                <div id="info-layout"></div>
                @include('page.header')
                <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <i class="bi bi-list fs-1"></i>
                </button>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container d-flex align-items-center justify-content-center p-4" style="background: #f5f5f5">
                @yield('content')
            </div>
        </main>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Hưng Thịnh Special Food</h5>
                <button type="button" class="btn-close text-reset fs-1" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="sidebar d-flex flex-column p-3 text-dark bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom">
                        <a href="#" class="text-dark text-decoration-none d-flex align-items-center mb-3">
                            <img src="{{ asset('logo/HungThinh.png') }}" alt="Logo" class="logo me-2"
                                style="width:50px; height: 50px;">
                        </a>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuProfile"
                                role="button">
                                <span class="text-dark">
                                    <img id="avatar" class="img-fluid rounded-circle"
                                        src="{{ Auth::user()->hinh ? asset('Uploads/' . Auth::user()->hinh) : asset('img-user/_default-user.png') }}"
                                        alt="User Avatar"
                                        style="width: 25px; height: 25px; object-fit: cover; cursor: pointer;">
                                    {{ Auth::user()->hoten }}
                                </span>
                            </a>
                            <ul id="menuProfile" class="collapse list-unstyled ps-3 bg-light text-dark">
                                <li><a class="nav-link d-flex align-items-center"
                                        href="{{ route('profile.profileUser', Auth::user()->id) }}">Thông tin tài
                                        khoản</a></li>
                                <li>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100">Logout</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link d-flex align-items-center">
                                <i class="bi bi-speedometer2 fs-4"></i>
                                <span class="text-dark">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/thongke" class="nav-link d-flex align-items-center">
                                <i class="bi bi-bar-chart fs-4"></i>
                                <span class="text-dark">Thống kê</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse"
                                href="#menuSanPham" role="button">
                                <i class="bi bi-box-seam fs-4"></i>
                                <span class="text-dark">Quản lý sản phẩm</span>
                            </a>
                            <ul id="menuSanPham" class="collapse list-unstyled bg-light ps-3 text-dark">
                                <li><a href="/sanpham" class="nav-link">Danh sách sản phẩm</a></li>
                                <li><a href="/danhmuc" class="nav-link">Danh sách danh mục</a></li>
                                <li><a href="/nhacungcap" class="nav-link">Quản lý nhà cung cấp</a></li>
                                <li><a href="/khoiluong" class="nav-link">Quản lý khối lượng</a></li>
                                <li><a href="/nhanbanh" class="nav-link">Quản lý nhân bánh</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/user" class="nav-link d-flex align-items-center">
                                <i class="bi bi-people fs-4"></i>
                                <span class="text-dark">Quản lý người dùng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('donhang.index') }}" class="nav-link d-flex align-items-center">
                                <i class="bi bi-box-seam fs-4"></i>
                                <span class="text-dark">Quản lý đơn hàng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse"
                                href="#menuBaiViet">
                                <i class="bi bi-file-earmark-text fs-4"></i>
                                <span class="text-dark">Quản lý bài viết</span>
                            </a>
                            <ul id="menuBaiViet" class="collapse list-unstyled ps-3 text-dark">
                                <li><a href="/baiviet" class="nav-link">Danh sách bài viết</a></li>
                                <li><a href="{{ route('danhmuc.index') }}" class="nav-link">Danh mục bài viết</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link d-flex align-items-center">
                                <i class="bi bi-tags fs-4"></i>
                                <span class="text-dark">Quản lý khuyến mãi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @yield('styles')
</body>

</html>
