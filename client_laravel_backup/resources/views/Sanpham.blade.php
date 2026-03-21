@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Cửa hàng')
@section('subtitle_url')
    {{ route('sanpham.index') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <form method="GET" action="{{ route('sanpham.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary" style="background-color: #fe9705; border: none;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: #80bb35;">
                    <h5 class="mb-0">Danh Mục Sản Phẩm</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('sanpham.index') }}">
                        <ul class="list-unstyled">
                            @foreach ($danhmucs as $danhmuc)
                                <li>
                                    <input type="checkbox" id="category-{{ $danhmuc->id }}" name="category[]"
                                        value="{{ $danhmuc->id }}"
                                        {{ in_array($danhmuc->id, request('category', [])) ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <label for="category-{{ $danhmuc->id }}">{{ $danhmuc->tendanhmuc }}</label>
                                </li>
                            @endforeach
                        </ul>
                        @foreach (request()->except(['category']) as $key => $value)
                            @if (!is_array($value))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: #80bb35;">
                    <h5 class="mb-0">Nhà Cung Cấp</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('sanpham.index') }}">
                        <ul class="list-unstyled">
                            @foreach ($nhacungcaps as $ncc)
                                <li>
                                    <input type="checkbox" id="supplier-{{ $ncc->id }}" name="supplier[]"
                                        value="{{ $ncc->id }}"
                                        {{ in_array($ncc->id, request('supplier', [])) ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <label for="supplier-{{ $ncc->id }}">{{ $ncc->tennhacungcap }}</label>
                                </li>
                            @endforeach
                        </ul>
                        @foreach (request()->except(['supplier']) as $key => $value)
                            @if (!is_array($value))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header text-white" style="background-color: #80bb35;">
                    <h5 class="mb-0">Lọc Theo Giá</h5>
                </div>
                <div class="card-body">
                    <div id="price-range"></div>
                    <p class="mt-2">Giá: <span id="price-range-value">0 đ - 1,000,000 đ</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
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

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-3">
                    <label for="sort" class="me-2">Sắp xếp:</label>
                    <div>
                        <form method="GET" action="{{ route('sanpham.index') }}">
                            <select name="sort" id="sort" class="form-select" style="width: 150px;"
                                onchange="this.form.submit()">
                                <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Mặc định
                                </option>
                                <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá tăng
                                    dần</option>
                                <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá giảm
                                    dần</option>
                            </select>
                            @foreach (request()->except(['sort']) as $key => $value)
                                @if (!is_array($value))
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @else
                                    @foreach ($value as $val)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $val }}">
                                    @endforeach
                                @endif
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row" id="product-list">
                @forelse ($bienthes as $bt)
                    @php
                        $sp = $bt->sanpham;
                    @endphp
                    <div class="col-12 col-md-3 mb-4 product-item" data-price="{{ $bt->gia ?? 0 }}">
                        <div class="card border-0 h-100 shadow-sm product-card" style="border-radius: 10px;">
                            <div class="position-relative overflow-hidden border-0">
                                <a href="{{ route('sanpham.detail', $bt->slug) }}">
                                    <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}"
                                        class="card-img-top card-image" alt="{{ $sp->tensp }}" style="height: 200px; object-fit: cover;" />
                                </a>
                                <button class="btn btn-preview position-absolute"
                                    style="top: 10px; right: 10px; background-color: white; color: gray;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#productModal{{ $sp->id }}_{{ $bt->id }}">
                                    <i class="bi bi-arrows-angle-expand"></i>
                                </button>

                                <button data-id="{{ $bt->id }}"
                                    data-url="{{ route('sanpham.detail', $bt->slug) }}"
                                    data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                    data-tensp="{{ $sp->tensp }}"
                                    class="btn btn-favorite position-absolute btn-wishlist"
                                    style="top: 55px; right: 10px; background-color: white; color: gray;">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </div>
                            <div class="card-body text-center position-relative d-flex flex-column overflow-hidden">
                                <div class="product-info flex-grow-1">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
                                        <h6 class="card-text mb-0" style="height: 50px;">
                                            <a href="{{ route('sanpham.detail', $bt->slug) }}"
                                                class="text-decoration-none text-dark">{{ $sp->tensp }}</a>
                                        </h6>
                                    </div>
                                    <p class="card-text text-muted mb-1">
                                        {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                        {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                    </p>
                                    <p class="card-text text-muted mb-2">Số lượng còn: {{ $bt->soluong ?? 0 }}</p>
                                </div>
                                <p class="card-text text-danger mt-auto mb-0">{{ number_format($bt->gia ?? 0) }} đ</p>
                                <form id="formAddToCart_{{ $sp->id }}_{{ $bt->id }}" method="POST"
                                    action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="id_bienthe" value="{{ $bt->id }}">
                                    <input type="hidden" name="soluong" value="1">
                                    <button type="submit" class="btn btn-primary btn-add-to-cart position-absolute w-100"
                                        style="bottom: 0px; left: 0; background-color: #fe9705; border: none;">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="productModal{{ $sp->id }}_{{ $bt->id }}" tabindex="-1"
                        aria-labelledby="productModalLabel{{ $sp->id }}_{{ $bt->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"
                                        id="productModalLabel{{ $sp->id }}_{{ $bt->id }}">
                                        {{ $sp->tensp }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a
                                                href="{{ route('sanpham.detail', $bt->slug) }}">
                                                <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}"
                                                    class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                                    style="height: 200px; object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ $sp->tensp }}</h4>
                                            <p class="text-muted mb-1">
                                                <b>Nhân bánh - Khối lượng:</b> {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                                {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                            </p>
                                            <p class="text-muted mb-1"><b>Số lượng còn:</b> {{ $bt->soluong ?? 0 }}</p>
                                            <h5 class="mb-1"><span
                                                    class="text-danger">{{ number_format($bt->gia ?? 0) }} đ</span></h5>
                                            <p class="text-muted mb-3"><b>Mô tả:</b> {{ $sp->mota ?? 'Không có mô tả.' }}
                                            </p>
                                            <form method="POST" action="{{ route('cart.add') }}">
                                                @csrf
                                                <div class="d-flex align-items-center mb-3">
                                                    <input type="hidden" name="id_bienthe" value="{{ $bt->id }}">
                                                    <input type="hidden" name="soluong" value="1">
                                                    <button type="submit" class="btn btn-primary"
                                                        style="background-color: #fe9705; border: none;">
                                                        Thêm vào giỏ
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="d-flex gap-3">
                                                <button data-id="{{ $bt->id }}"
                                                    data-url="{{ route('sanpham.detail', $bt->slug) }}"
                                                    data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                                    data-tensp="{{ $sp->tensp }}"
                                                    class="btn btn-favorite position-absolute btn-wishlist"
                                                    style="top: 55px; right: 10px; background-color: white; color: gray;">
                                                    <i class="bi bi-heart-fill"></i>
                                                </button>
                                            </div>
                                            <p class="text-muted mt-3"><b>Danh mục:</b>
                                                {{ $sp->danhmuc->tendanhmuc ?? 'Không có danh mục' }}</p>
                                            <p class="text-muted"><b>Nhà cung cấp:</b>
                                                {{ $sp->nhacungcap->tennhacungcap ?? 'Không có nhà cung cấp' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Không tìm thấy sản phẩm nào.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $bienthes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            let minPrice = Number.MAX_VALUE,
                maxPrice = 0;
            $('.product-item').each(function() {
                const price = parseInt($(this).data('price'));
                minPrice = Math.min(minPrice, price);
                maxPrice = Math.max(maxPrice, price);
            });
            minPrice = minPrice === Number.MAX_VALUE ? 0 : minPrice;
            maxPrice = maxPrice === 0 ? 500000 : maxPrice;

            $("#price-range").slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [minPrice, maxPrice],
                slide: function(event, ui) {
                    $("#price-range-value").text(
                        new Intl.NumberFormat().format(ui.values[0]) + " đ - " +
                        new Intl.NumberFormat().format(ui.values[1]) + " đ"
                    );
                    $('.product-item').each(function() {
                        const price = parseInt($(this).data('price'));
                        $(this).toggle(price >= ui.values[0] && price <= ui.values[1]);
                    });
                }
            });

            $("#price-range-value").text(
                new Intl.NumberFormat().format(minPrice) + " đ - " +
                new Intl.NumberFormat().format(maxPrice) + " đ"
            );
        });

        function getWishlist() {
            return JSON.parse(localStorage.getItem('data')) || [];
        }

        function setWishlist(list) {
            localStorage.setItem('data', JSON.stringify(list));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isLoggedIn = document.querySelector('meta[name="is-logged-in"]').getAttribute('content') === '1';

            document.querySelectorAll('.btn-wishlist').forEach(button => {
                button.addEventListener('click', function() {
                    const id_bienthe = this.getAttribute('data-id');
                    const tensp = this.getAttribute('data-tensp');
                    const hinh = this.getAttribute('data-hinh');
                    const gia = this.getAttribute('data-gia');
                    const giakm = this.getAttribute('data-giakm') || gia;

                    if (!isLoggedIn) {

                        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
                        const exists = favorites.find(item => item.id_bienthe === id_bienthe);

                        if (!exists) {
                            favorites.push({
                                id_bienthe,
                                tensp,
                                hinh,
                                gia,
                                giakm
                            });
                            localStorage.setItem('favorites', JSON.stringify(favorites));
                            alert('Đã thêm vào yêu thích ');
                        } else {
                            alert('Sản phẩm đã có trong yêu thích!');
                        }

                        document.querySelector('#favorites-count').textContent =
                            `(${favorites.length})`;
                    } else {

                        const yeuthichAddUrl = document.querySelector(
                            'meta[name="yeuthich-add-url"]').getAttribute('content');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');

                        fetch(yeuthichAddUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    id_bienthe,
                                    tensp,
                                    hinh,
                                    gia,
                                    giakm
                                })
                            })
                            .then(response => {
                                if (!response.ok) throw new Error('Lỗi mạng: ' + response
                                    .status);
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    alert('Đã thêm vào yêu thích!');
                                    document.querySelector('#favorites-count').textContent =
                                        `(${data.favoritesCount})`;
                                } else {
                                    alert(data.message || 'Sản phẩm đã có trong yêu thích!');
                                    document.querySelector('#favorites-count').textContent =
                                        `(${data.favoritesCount || 0})`;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Đã xảy ra lỗi khi thêm vào yêu thích.');
                            });
                    }
                });
            });
        });
    </script>
@endsection

<style>
    .pagination .page-item .page-link {
        border-radius: 50%;
        border: none;
        background-color: transparent;
        color: #666;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #fe9705;
        color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .pagination .page-item .page-link:hover {
        background-color: #fe9705;
        color: white;
        transform: scale(1.1);
    }

    #price-range {
        margin-bottom: 15px;
    }

    .product-card .product-image {
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .btn-add-to-cart {
        display: none;
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .product-card:hover .btn-add-to-cart {
        display: block;
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.5s ease forwards;
    }

    .btn-add-to-cart:hover {
        background-color: #ffe5c1 !important;
        color: black !important;
    }

    .btn-favorite,
    .btn-preview {
        display: none !important;
    }

    .product-card:hover .btn-favorite,
    .product-card:hover .btn-preview {
        display: block !important;
        animation: fadeInRight 0.5s ease forwards;
    }

    .btn-favorite:hover {
        background-color: red !important;
        color: white !important;
    }

    .btn-preview:hover {
        background-color: #80bb35 !important;
        color: white !important;
    }

    .card-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .product-info {
        transition: filter 0.3s ease;
    }

    .card-body {
        position: relative;
        padding-bottom: 40px;
    }

    .card-body .text-danger {
        font-weight: bold;
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>