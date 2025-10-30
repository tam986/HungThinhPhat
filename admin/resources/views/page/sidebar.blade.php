<div class="sidebar d-flex flex-column p-3 text-dark bg-white shadow-sm">
    <div class="d-flex justify-content-center border-bottom">
        <a href="/dashboard" class=" text-dark text-decoration-none d-flex align-items-center mb-3">
            <img src="{{ asset('logo/HungThinh.png') }}" alt="Logo" class="logo me-2 d-block"
                style="width:100px;height:100px">
        </a>
    </div>


    <ul class="nav nav-pills flex-column ">
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
            <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuSanPham" role="button">
                <i class="bi bi-box-seam fs-4"></i>
                <span class="text-dark">Quản lý sản phẩm</span>
            </a>
            <ul id="menuSanPham" class="collapse list-unstyled ps-3 text-dark">
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
            <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuBaiViet">
                <i class="bi bi-file-earmark-text fs-4"></i>
                <span class="text-dark">Quản lý bài viết</span>
            </a>
            <ul id="menuBaiViet" class="collapse list-unstyled ps-3 text-dark">
                <li><a href="/baiviet" class="nav-link">Danh sách bài viết</a></li>
                <li><a href="{{ route('danhmuc.index') }}" class="nav-link">Danh mục bài viết</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('magiamgia.index') }}" class="nav-link d-flex align-items-center">
                <i class="bi bi-tags fs-4"></i>
                <span class="text-dark">Quản lý khuyến mãi</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('binhluans.index') }}" class="nav-link d-flex align-items-center">
                <i class="bi bi-tags fs-4"></i>
                <span class="text-dark">Quản lý bình luận</span>
            </a>
        </li>
    </ul>
</div>

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

    /* Tạo khoảng cách giữa icon và chữ */
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

    /* Hiệu ứng hover */
    .nav-link:hover {
        background-color: #0d6efd;
        /* Bootstrap primary blue */
        color: #fff;
    }

    /* Dropdown menu styling */
    .collapse .nav-link {
        padding-left: 30px;
    }

    /* Ẩn chữ khi màn hình nhỏ */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
        }


    }
</style>
