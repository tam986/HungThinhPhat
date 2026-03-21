<nav class="navbar navbar-expand-lg p-0">
    <div class="container">

        <a class="navbar-brand p-1 d-lg-none" href="#">
            <img src="/logo/HungThinh.png" alt="Logo" height="60">
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarSupportedContent">
            <div class="d-block d-md-none">
                @if (Auth::user())
                    <div>
                        <h5 class="text-center mt-4 mb-4"><span class="text-white">Xin chào</span> ,
                            {{ Auth::user()->hoten }}!
                        </h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div>
                        <h5 class="text-center mt-4 mb-4"><span class="text-white">Xin chào</span> , bạn!</h5>
                    </div>
                @endif
            </div>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item menu">
                    <a class="nav-link text-white" href="{{ route('client.home') }}"><strong>Trang chủ</strong></a>
                </li>
                <li class="nav-item menu">
                    <a class="nav-link text-white" href="{{ route('sanpham.index') }}"><strong>Cửa hàng</strong></a>
                </li>
                <li class="nav-item menu">
                    <a class="nav-link text-white" href="{{ route('baiviet.index') }}"><strong>Bài viết</strong></a>
                </li>
                <li class="nav-item menu">
                    <a class="nav-link text-white" href="{{ route('lienhe.form') }}"><strong>Liên hệ</strong></a>
                </li>

            </ul>
 <!-- Tìm kiếm -->
            <form class="d-flex mt-2 mt-lg-2 p-0" method="get" action="{{ route('nav.search') }}">
                <input class="form-control me-2" type="text" name="query" placeholder="Tìm kiếm sản phẩm..."
                    value="{{ request('query') }}">
                <button class="btn btn-light text-white" type="submit" style="background-color:#fe9705">Tìm</button>
            </form>
        </div>
    </div>
</nav>

<div class="d-md-none fixed-bottom  border-top d-flex justify-content-around text-center py-2 shadow-sm rounded rounded-top-left rounded-top-right"
    style="background-color: #fe9705;">
    <a href="{{ route('client.home') }}" class="text-decoration-none text-white">
        <i class="bi bi-house-door fs-4"></i><br />
        <small>Home</small>
    </a>
    <a href="/sanpham" class="text-decoration-none text-white">
        <i class="bi bi-heart fs-4"></i><br />
        <small>Cửa hàng</small>
    </a>
    <a href="{{route('profile.order')}}" class="text-decoration-none text-white">
        <i class="bi bi-clipboard-check fs-4"></i><br />
        <small>Đơn hàng</small>
    </a>
    @if (Auth::user())
        <a href="{{ route('profile.profileUser') }}" class="text-decoration-none text-white">
            <i class="bi bi-person-circle fs-4"></i><br />
            <small>User</small>
        </a>
    @else
        <a href="{{ route('login.form') }}" class="text-decoration-none text-white">
            <i class="bi bi-person-circle fs-4"></i><br />
            <small>User</small>
        </a>
    @endif
</div>
<style>
    .nav-item {
        line-height: 24px;
        padding: 10px 20px;
    }

    #nav-active {
        background: #fe9705;
    }

    .menu:hover {
        background: #fe9705;
    }
</style>
