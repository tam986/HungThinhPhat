<div class="container p-4 d-flex d-none d-md-flex justify-content-between align-items-center flex-wrap">
    <!-- Logo -->
    <div class="d-flex align-items-center d-none d-md-block">
        <div class="ms-2  text-center w-100 py-2">
            <a href="{{ route('client.home') }}"> <img src="{{ asset('logo/HungThinh.png') }}" alt="Logo"
                    class="img-fluid" style="width:100px; height: auto;" /></a>

        </div>
    </div>

    <div class="d-none d-md-flex justify-content-center align-items-center flex-grow-1 gap-4">
        <div class="d-flex align-items-center">
            <i class="bi bi-truck fs-3 text-warning me-2"></i>
            <div>
                <div class="fw-bold">Miễn phí vận chuyển</div>
                <small>Bán kính 100 km</small>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <i class="bi bi-envelope fs-3 text-danger me-2"></i>
            <div>
                <div class="fw-bold">Hỗ trợ 24/7</div>
                <small>Hotline: 19001009</small>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <i class="bi bi-clock fs-3 text-primary me-2"></i>
            <div>
                <div class="fw-bold">Giờ làm việc</div>
                <small>T2 - T7 Giờ hành chính</small>
            </div>
        </div>
    </div>

    <!-- Giỏ hàng (chỉ hiện ở desktop) -->
    <div class="d-none d-md-flex justify-content-between align-items-center gap-3">
        <a href="{{ route('profile.product') }}" class="btn btn-danger text-white">
            <i class="bi bi-heart-fill"></i> <span id="favorites-count">({{ $favoritesCount }})</span>
        </a>
        <a href="/cart" type="button" class="btn btn-primary position-relative">
            <i class="bi bi-bag me-1"></i> ({{ $totalItems ?? 0 }})
        </a>
        <div class="dropdown-down shadow-sm dropdown-menu-end">
            <a class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-fill"></i>
            </a>
            <ul class="dropdown-menu">
                @if (Auth::user())
                    <div id="card-profile" class="card rounded bg-white border-0 ">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <img class="img-fluid rounded-circle"
                                    src="{{ Auth::user()->hinh ? asset('storage/' . Auth::user()->hinh) : asset('img-user/_default-user.png') }}"
                                    alt="User Avatar" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div>
                                <p class="mt-2" style="font-size:16px;line-height:24px">{{ Auth::user()->hoten }}</p>
                            </div>


                        </div>
                        <div class="card-body" style="width:400px">
                            <ul class="nav nav-pills flex-column ">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center"
                                        href="{{ route('profile.profileUser', [Auth::user()->id]) }}">Thông tin
                                        tài
                                        khoản</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center"
                                        href="{{ route('profile.order', Auth::user()->id) }}">Đơn hàng của tôi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center"
                                        href="{{ route('profile.product', Auth::user()->id) }}">Sản phẩm yêu thích</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 p-3"><span
                                        class="d-flex gap-4 justify-content-center"><i
                                            class="bi bi-box-arrow-right fs-5 pl-5"></i> Đăng
                                        xuất</span> </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class=" d-flex justify-content-center align-items-center">
                        <li><a class="dropdown-item" href="{{ route('login.form') }}">Đăng nhập</a></li>
                        /
                        <li><a class="dropdown-item" href="/register">Đăng ký</a></li>
                    </div>
                @endif

            </ul>
        </div>

    </div>
</div>
