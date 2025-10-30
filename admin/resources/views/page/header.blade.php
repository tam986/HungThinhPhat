<nav class="navbar container d-flex justify-content-between align-items-center navbar-dark px-3">
    <div>
        <a href="/dashboard" class=" text-dark text-decoration-none d-flex align-items-center mb-3">
            <img src="{{ asset('logo/HungThinh.png') }}" alt="Logo" class="logo me-2 d-block"
                style="width:100px;height:100px">
        </a>
    </div>
    <div class="d-flex gap-2 align-items-center">
       <div class="latest-order-container">
            @php
                $latestOrder = App\Models\Donhang::latest()->first();
            @endphp
            @if ($latestOrder)
                <div class="latest-order text-dark">
                    <strong>Đơn hàng mới nhất:</strong>
                    <a href="{{ route('donhang.show', $latestOrder->id) }}">
                        #DH{{ $latestOrder->id }} - {{ $latestOrder->tennguoinhan }} -
                        {{ number_format($latestOrder->thanhtien, 0, ',', '.') }} VNĐ
                    </a>
                </div>
            @else
                <div class="latest-order text-muted">
                    Chưa có đơn hàng nào
                </div>
            @endif
        </div>
        <div class="bg-light rounded">
            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                aria-controls="offcanvasScrolling">
                <strong><i class="bi bi-people-fill text-success fs-3 p-1"></i></strong>
            </button>

            <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
                id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Danh sách Admin</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="" method="GET" class="input-group w-auto mr-3">
                        <input type="text" name="search" class="form-control bg-white text-black"
                            placeholder="Tìm kiếm..." value="{{ request('search') }}">
                        <button class="btn btn-outline-dark border-0 shadow-sm" type="submit"><i
                                class="fas fa-search"></i></button>
                    </form>


                    <ul class="list-group mt-3">
                        @include('page.online')
                    </ul>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle rounded rounded-5" type="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid rounded"
                    src="{{ Auth::user()->hinh ? asset('uploads/' . Auth::user()->hinh) : asset('img-user/_default-user.png') }}"
                    alt="User Avatar" style="width: 25px; height: 25px; object-fit: cover; cursor: pointer;">
                {{ Auth::user()->hoten }}
            </button>

            <div class="dropdown-menu shadow-sm dropdown-menu-end" aria-labelledby="userDropdown">
                <div id="card-profile" class="card rounded bg-white border-0 ">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <img class="img-fluid rounded-circle"
                                src="{{ Auth::user()->hinh ? asset('uploads/' . Auth::user()->hinh) : asset('img-user/_default-user.png') }}"
                                alt="User Avatar" style="width: 50px; height: 50px; object-fit: cover;">
                        </div>
                        <div>
                            <p class="mt-2" style="font-size:16px;line-height:24px">{{ Auth::user()->hoten }}</p>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">Logout</button>
                            </form>
                        </div>

                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column ">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center"
                                    href="{{ route('profile.profileUser', Auth::user()->id) }}">Thông tin
                                    tài
                                    khoản</a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>

</nav>

<style>
    .bell-icon {
        font-size: 30px;
        cursor: pointer;
        position: relative;
    }

    .notification-badge {
        position: absolute;
        color: red;
        top: -5px;
        /* Đặt badge phía trên chuông */
        right: -5px;
        /* Đặt badge phía bên phải chuông */
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        font-size: 12px;
        display: none;
        /* Ẩn badge nếu không có thông báo */
    }

    .notification-dropdown {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        width: 300px;
        left: 50%;
        max-height: 200px;
        overflow-y: auto;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: none;
        z-index: 1001;
    }

    .notification-dropdown ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .notification-dropdown li {
        padding: 10px;
        border-bottom: 1px solid #f1f1f1;
    }

    .notification-dropdown li:last-child {
        border-bottom: none;
    }

    #notification-list {
        padding: 10px;
    }

    .notification-dropdown li.read {
        background-color: #f9f9f9;
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

    @media(min-width:768px) {
        #card-profile {
            width: 200px;
        }
    }

    @media(min-width:1024px) {
        #card-profile {
            width: 350px;
        }
    }
</style>
