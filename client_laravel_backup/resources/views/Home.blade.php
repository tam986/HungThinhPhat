@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('content')
    <div class="container">
        {{-- cat --}}
        <div class="row">
            <div class="col-md-3 rounded mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header shadow-sm rounded text-center text-white" style="background-color:#80bb35;">
                        <h5>DANH MỤC</h5>
                    </div>
                    <div class="card-body">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-start">
                            @foreach ($danhmucs as $danhmuc)
                                <li class="nav-item danhmuc">
                                    <a class="nav-link text-dark"
                                        href="{{ route('sanpham.index', ['danhmuc' => [$danhmuc->id]]) }}">
                                        <strong>{{ $danhmuc->tendanhmuc }}</strong></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-9 rounded shadow-sm p-0 mb-4">
                <div id="banner" class="carousel slide">
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/uploads/img-banner/banner1.jpeg') }}" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('storage/uploads/img-banner/banner2.jpg') }}" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('storage/uploads/img-banner/banner3.jpg') }}" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        {{-- voucher --}}
        <div class="container mt-4">
            <h5>Voucher xịn xò</h5>
            <div id="voucher" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded">
                    @if ($voucher && count($voucher))
                        @foreach ($voucher->chunk(4) as $chunkIndex => $voucherChunk)
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row p-4">
                                    @foreach ($voucherChunk as $phieugiamgia)
                                        <div class="text-center col-md-3 mb-4" style="width: 300px;">
                                            <div class="rounded-top p-3"
                                                style="background: radial-gradient(circle at center, #ee9ca7 0%, #ffdde1 100%);">
                                                <h5 class="text-white mb-2">{{ $phieugiamgia->magiamgia }}</h5>
                                                <span class="text-white"><i>Giảm
                                                        {{ number_format($phieugiamgia->sotientoithieu, 0, ',', '.') }}
                                                        Đ</i></span>
                                            </div>
                                            <div class="rounded-bottom p-3"
                                                style="background: radial-gradient(circle at center, #ee9ca7 0%, #ffdde1 100%);">
                                                <a class="btn btn-outline-light fw-bold" href="/sanpham">Mua
                                                    ngay</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-center">
                                <div class="text-center" style="width: 360px;">
                                    <div class="rounded-top p-3"
                                        style="background: radial-gradient(circle at center, #ee9ca7 0%, #ffdde1 100%);">
                                        <h5 class="text-white mb-0">Chưa có voucher mới</h5>
                                    </div>
                                    <div class="rounded-bottom p-3"
                                        style="background: radial-gradient(circle at center, #ee9ca7 0%, #ffdde1 100%);">
                                        <a class="btn btn-outline-light fw-bold" href="/sanpham">Mua ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>


                <button class="carousel-control-prev" type="button" data-bs-target="#voucher" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#voucher" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>
        {{-- end voucher --}}
        {{-- sản phẩm mới --}}
        <section>
            <div class="container mt-4 bg-light rounded d-flex justify-content-between align-items-center p-0">
                <div class=" container title">
                    <h5>Sản phẩm mới</h5>
                </div>
                <div class="rounded p-2" style="background-color:#fe9705;">
                    <a type="button" href="" class="btn" style="width:100px;">Xem thêm</a>
                </div>
            </div>
            <div class="container bg-light mt-4 rounded">
                <div class="row p-4" id="product-list">
                    @forelse ($products as $bt)
                        @php
                            $sp = $bt->sanpham;
                        @endphp
                        <div class="col-md-3 mb-4 product-item" data-price="{{ $bt->gia ?? 0 }}">
                            <div class="card h-100 shadow-sm product-card" style="border-radius: 10px;">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                        <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}" class="card-img-top product-image"
                                            alt="{{ $sp->tensp }}" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-preview position-absolute"
                                        style="top: 10px; right: 10px; background-color: white; color: gray;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#productModal{{ $sp->id }}_{{ $bt->id }}">
                                        <i class="bi bi-arrows-angle-expand"></i>
                                    </button>
                                    <button data-id="{{ $bt->id }}" data-favorited="true"
                                        data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                        data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                        data-tensp="{{ $sp->tensp }}"
                                        class="btn btn-favorite position-absolute btn-wishlist"
                                        style="top: 55px; right: 10px; background-color: white; color: gray;">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </div>
                                <div class="card-body text-center position-relative d-flex flex-column overflow-hidden">
                                    <div class="product-info flex-grow-1">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="height: 50px;">
                                            <h6 class="card-text mb-0" style="height: 50px;">
                                                <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                    class="text-decoration-none text-dark">{{ $sp->tensp }}</a>
                                            </h6>
                                        </div>
                                        <p class="card-text text-muted mb-1">
                                            {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                            {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                        </p>
                                        <p class="card-text text-muted mb-2">
                                            Số lượng còn: {{ $bt->soluong ?? 0 }}
                                        </p>
                                    </div>
                                    <p class="card-text text-danger mt-auto mb-0">
                                        {{ number_format($bt->gia ?? 0) }} đ
                                    </p>
                                    <form id="formAddToCart_{{ $sp->id }}_{{ $bt->id }}" method="POST"
                                        action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="id_bienthe" value="{{ $bt->id }}">
                                        <input type="hidden" name="soluong" value="1">
                                        <button type="submit"
                                            class="btn btn-primary btn-add-to-cart position-absolute w-100"
                                            style="bottom: 0px; left: 0; background-color: #fe9705; border: none;">
                                            Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="productModal{{ $sp->id }}_{{ $bt->id }}" tabindex="-1"
                            aria-labelledby="productModalLabel{{ $sp->id }}_{{ $bt->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="productModalLabel{{ $sp->id }}_{{ $bt->id }}">
                                            {{ $sp->tensp }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a
                                                    href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                                    <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}"
                                                        class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                                        style="height: 200px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>{{ $sp->tensp }}</h4>
                                                <p class="text-muted mb-1">
                                                    <b>Nhân bánh - Khối lượng:</b>
                                                    {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                                    {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                                </p>
                                                <p class="text-muted mb-1">
                                                    <b>Số lượng còn:</b> {{ $bt->soluong ?? 0 }}
                                                </p>
                                                <h5 class="mb-1">
                                                    <span class="text-danger">{{ number_format($bt->gia ?? 0) }}
                                                        đ</span>
                                                </h5>
                                                <p class="text-muted mb-3">
                                                    <b>Mô tả:</b> {{ $sp->mota ?? 'Không có mô tả.' }}
                                                </p>
                                                <form method="POST" action="{{ route('cart.add') }}">
                                                    @csrf
                                                    <div class="d-flex align-items-center mb-3">
                                                        <input type="hidden" name="id_bienthe"
                                                            value="{{ $bt->id }}">
                                                        <input type="hidden" name="soluong" value="1">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="background-color: #fe9705; border: none;">
                                                            Thêm vào giỏ
                                                        </button>
                                                    </div>
                                                </form>
                                                <div class="d-flex gap-3">
                                                    <button data-id="{{ $bt->id }}"
                                                        data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                        data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                                        data-tensp="{{ $sp->tensp }}"
                                                        class="btn btn-outline-secondary btn-wishlist"
                                                        style="background-color: transparent; border: 1px solid #ced4da;">
                                                        <i class="bi bi-heart"></i> Thêm vào yêu thích
                                                    </button>
                                                </div>
                                                <p class="text-muted mt-3"><b>Danh mục:</b>
                                                    {{ $sp->danhmuc->tendanhmuc ?? 'Không có danh mục' }}</p>
                                                <p class="text-muted"><b>Nhà cung cấp:</b>
                                                    {{ $sp->nhacungcap->tennhacungcap ?? 'Không có nhà cung cấp' }}
                                                </p>
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
            </div>
        </section>
        {{-- sn phẩm nổi bật --}}
        <section>
            <div class="container mt-4 bg-light rounded d-flex justify-content-between align-items-center p-0">
                <div class=" container title">
                    <h5>Sản phẩm nổi bật</h5>
                </div>
                <div class="rounded p-2" style="background-color:#fe9705;">
                    <button type="button" class="btn" style="width:100px;">Xem thêm</button>
                </div>
            </div>
            <div class="container bg-light mt-4 rounded">
                <div class="row p-4" id="product-list">
                    @forelse ($productView as $bt)
                        @php
                            $sp = $bt->sanpham;
                        @endphp
                        <div class="col-md-3 mb-4 product-item" data-price="{{ $bt->gia ?? 0 }}">
                            <div class="card h-100 shadow-sm product-card" style="border-radius: 10px;">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                        <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}" class="card-img-top product-image"
                                            alt="{{ $sp->tensp }}" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-preview position-absolute"
                                        style="top: 10px; right: 10px; background-color: white; color: gray;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#productModal{{ $sp->id }}_{{ $bt->id }}">
                                        <i class="bi bi-arrows-angle-expand"></i>
                                    </button>
                                    <button data-id="{{ $bt->id }}"
                                        data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                        data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                        data-tensp="{{ $sp->tensp }}"
                                        class="btn btn-favorite position-absolute btn-wishlist"
                                        style="top: 55px; right: 10px; background-color: white; color: gray;">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </div>
                                <div class="card-body text-center position-relative d-flex flex-column overflow-hidden">
                                    <div class="product-info flex-grow-1">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="height: 50px;">
                                            <h6 class="card-text mb-0" style="height: 50px;">
                                                <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                    class="text-decoration-none text-dark">{{ $sp->tensp }}</a>
                                            </h6>
                                        </div>
                                        <p class="card-text text-muted mb-1">
                                            {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                            {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                        </p>
                                        <p class="card-text text-muted mb-2">
                                            Số lượng còn: {{ $bt->soluong ?? 0 }}
                                        </p>
                                    </div>
                                    <p class="card-text text-danger mt-auto mb-0">
                                        {{ number_format($bt->gia ?? 0) }} đ
                                    </p>
                                    <form id="formAddToCart_{{ $sp->id }}_{{ $bt->id }}" method="POST"
                                        action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="id_bienthe" value="{{ $bt->id }}">
                                        <input type="hidden" name="soluong" value="1">
                                        <button type="submit"
                                            class="btn btn-primary btn-add-to-cart position-absolute w-100"
                                            style="bottom: 0px; left: 0; background-color: #fe9705; border: none;">
                                            Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="productModal{{ $sp->id }}_{{ $bt->id }}" tabindex="-1"
                            aria-labelledby="productModalLabel{{ $sp->id }}_{{ $bt->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="productModalLabel{{ $sp->id }}_{{ $bt->id }}">
                                            {{ $sp->tensp }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a
                                                    href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                                    <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}"
                                                        class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                                        style="height: 200px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>{{ $sp->tensp }}</h4>
                                                <p class="text-muted mb-1">
                                                    <b>Nhân bánh - Khối lượng:</b>
                                                    {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                                    {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                                </p>
                                                <p class="text-muted mb-1">
                                                    <b>Số lượng còn:</b> {{ $bt->soluong ?? 0 }}
                                                </p>
                                                <h5 class="mb-1">
                                                    <span class="text-danger">{{ number_format($bt->gia ?? 0) }}
                                                        đ</span>
                                                </h5>
                                                <p class="text-muted mb-3">
                                                    <b>Mô tả:</b> {{ $sp->mota ?? 'Không có mô tả.' }}
                                                </p>
                                                <form method="POST" action="{{ route('cart.add') }}">
                                                    @csrf
                                                    <div class="d-flex align-items-center mb-3">
                                                        <input type="hidden" name="id_bienthe"
                                                            value="{{ $bt->id }}">
                                                        <input type="hidden" name="soluong" value="1">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="background-color: #fe9705; border: none;">
                                                            Thêm vào giỏ
                                                        </button>
                                                    </div>
                                                </form>
                                                <div class="d-flex gap-3">
                                                    <button data-id="{{ $bt->id }}"
                                                        data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                        data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                                        data-tensp="{{ $sp->tensp }}"
                                                        class="btn btn-outline-secondary btn-wishlist"
                                                        style="background-color: transparent; border: 1px solid #ced4da;">
                                                        <i class="bi bi-heart"></i> Thêm vào yêu thích
                                                    </button>
                                                </div>
                                                <p class="text-muted mt-3"><b>Danh mục:</b>
                                                    {{ $sp->danhmuc->tendanhmuc ?? 'Không có danh mục' }}</p>
                                                <p class="text-muted"><b>Nhà cung cấp:</b>
                                                    {{ $sp->nhacungcap->tennhacungcap ?? 'Không có nhà cung cấp' }}
                                                </p>
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
            </div>
        </section>
        {{-- banner giữa --}}
        <section id="banner-1"
            class="container rounded mt-4 text-center d-flex align-items-center justify-content-center">
            <div class="container">
                <img src="{{ asset('/storage/uploads/img-banner/bannerSale.png') }}" class="img-fluid d-block w-100"
                    alt="">
            </div>

        </section>
        {{-- sản phẩm giảm giá --}}
        <section>
            <div class="container mt-4 bg-light rounded d-flex justify-content-between align-items-center p-0">
                <div class=" container title">
                    <h5>Sản phẩm đang giảm giá</h5>
                </div>
                <div class="rounded p-2" style="background-color:#fe9705;">
                    <button type="button" class="btn" style="width:100px;">Xem thêm</button>
                </div>
            </div>
            <div class="container bg-light mt-4 rounded">
                <div class="row p-4" id="product-list">
                    @forelse ($productDiscount as $bt)
                        @php
                            $sp = $bt->sanpham;
                        @endphp
                        <div class="col-md-3 mb-4 product-item" data-price="{{ $bt->gia ?? 0 }}">
                            <div class="card h-100 shadow-sm product-card" style="border-radius: 10px;">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                        <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}"
                                            class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                            style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-preview position-absolute"
                                        style="top: 10px; right: 10px; background-color: white; color: gray;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#productModal{{ $sp->id }}_{{ $bt->id }}">
                                        <i class="bi bi-arrows-angle-expand"></i>
                                    </button>
                                    <button data-id="{{ $bt->id }}"
                                        data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                        data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                        data-tensp="{{ $sp->tensp }}"
                                        class="btn btn-favorite position-absolute btn-wishlist"
                                        style="top: 55px; right: 10px; background-color: white; color: gray;">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </div>
                                <div class="card-body text-center position-relative d-flex flex-column overflow-hidden">
                                    <div class="product-info flex-grow-1">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="height: 50px;">
                                            <h6 class="card-text mb-0" style="height: 50px;">
                                                <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                    class="text-decoration-none text-dark">{{ $sp->tensp }}</a>
                                            </h6>
                                        </div>
                                        <p class="card-text text-muted mb-1">
                                            {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                            {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                        </p>
                                        <p class="card-text text-muted mb-2">
                                            Số lượng còn: {{ $bt->soluong ?? 0 }}
                                        </p>
                                    </div>
                                    <p class="card-text text-danger mt-auto mb-0">
                                        {{ number_format($bt->gia ?? 0) }} đ
                                    </p>
                                    <form id="formAddToCart_{{ $sp->id }}_{{ $bt->id }}" method="POST"
                                        action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="id_bienthe" value="{{ $bt->id }}">
                                        <input type="hidden" name="soluong" value="1">
                                        <button type="submit"
                                            class="btn btn-primary btn-add-to-cart position-absolute w-100"
                                            style="bottom: 0px; left: 0; background-color: #fe9705; border: none;">
                                            Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="productModal{{ $sp->id }}_{{ $bt->id }}" tabindex="-1"
                            aria-labelledby="productModalLabel{{ $sp->id }}_{{ $bt->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="productModalLabel{{ $sp->id }}_{{ $bt->id }}">
                                            {{ $sp->tensp }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a
                                                    href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                                    <img src="{{ config('app.cms_url') . '/storage/' . $bt->hinh }}"
                                                        class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                                        style="height: 200px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>{{ $sp->tensp }}</h4>
                                                <p class="text-muted mb-1">
                                                    <b>Nhân bánh - Khối lượng:</b>
                                                    {{ $bt->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                                    {{ $bt->khoiluong->khoiluong ?? 'N/A' }}g
                                                </p>
                                                <p class="text-muted mb-1">
                                                    <b>Số lượng còn:</b> {{ $bt->soluong ?? 0 }}
                                                </p>
                                                <h5 class="mb-1">
                                                    <span class="text-danger">{{ number_format($bt->gia ?? 0) }}
                                                        đ</span>
                                                </h5>
                                                <p class="text-muted mb-3">
                                                    <b>Mô tả:</b> {{ $sp->mota ?? 'Không có mô tả.' }}
                                                </p>
                                                <form method="POST" action="{{ route('cart.add') }}">
                                                    @csrf
                                                    <div class="d-flex align-items-center mb-3">
                                                        <input type="hidden" name="id_bienthe"
                                                            value="{{ $bt->id }}">
                                                        <input type="hidden" name="soluong" value="1">
                                                        <button type="submit" class="btn btn-primary"
                                                            style="background-color: #fe9705; border: none;">
                                                            Thêm vào giỏ
                                                        </button>
                                                    </div>
                                                </form>
                                                <div class="d-flex gap-3">
                                                    <button data-id="{{ $bt->id }}"
                                                        data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                        data-gia="{{ $bt->gia ?? 0 }}" data-hinh="{{ $bt->hinh }}"
                                                        data-tensp="{{ $sp->tensp }}"
                                                        class="btn btn-outline-secondary btn-wishlist"
                                                        style="background-color: transparent; border: 1px solid #ced4da;">
                                                        <i class="bi bi-heart"></i> Thêm vào yêu thích
                                                    </button>
                                                </div>
                                                <p class="text-muted mt-3"><b>Danh mục:</b>
                                                    {{ $sp->danhmuc->tendanhmuc ?? 'Không có danh mục' }}</p>
                                                <p class="text-muted"><b>Nhà cung cấp:</b>
                                                    {{ $sp->nhacungcap->tennhacungcap ?? 'Không có nhà cung cấp' }}
                                                </p>
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
            </div>
        </section>
        {{-- bài viết --}}
        <section>
            <aside class=" d-flex justify-content-between align-items-center p-0 rounded mt-4"
                style="
              width:100%;
              height:auto;
              background-color: #fff;
            
            ">
                <div class=" container title">
                    <h5>
                        Bài viết
                    </h5>
                </div>
                <div class="p-1 rounded" style="background-color:#fe9705;">
                    <a type="button" href="/baiviet" class="btn" style="width:100px;">Xem
                        thêm</a>
                </div>
            </aside>
            <div class="container bg-light mt-4 rounded">
                <div class="row p-4">
                    @foreach ($baivietNoiBat as $bv)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('baiviet.show', ['slug' => $bv->slug]) }}">
                                <div class="card custom-card">
                                    <div class="card-body custom-card-body p-0">
                                        <div class="image-container">
                                            <img src="{{ config('app.cms_url') . '/storage/' . $bv->anhdaidien }}"
                                                class="card-image rounded" alt="chưa lấy được ảnh" />
                                        </div>

                                        <div class="content-container d-flex justify-content-between flex-column">
                                            <div class="eye-icon">
                                                <div class="rounded text-center"
                                                    style="background-color: orange; width: 100px;">
                                                    <h5>{{ $bv->danhmuc->tendm }}</h5>
                                                </div>
                                                <div>👁️ {{ $bv->luotxem }}</div>
                                            </div>

                                            <div>
                                                <h6 class="card-title">{{ $bv->tieude }}</h6>
                                                <span>{{ $bv->created_at->format('d/m/Y') }}</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        {{-- end bài viết --}}
        {{-- bình luận --}}
        <section>
            <aside class=" d-flex justify-content-between align-items-center p-0 rounded mt-4"
                style="
              width:100%;
              height:auto;
              background-color: #fff;
            
            ">
                <div class=" container title-binhluan">
                    <h5>
                        Bình luận
                    </h5>
                </div>
            </aside>
            <div class="container bg-light mt-4 rounded">
                <div class="row p-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="container mb-4 d-flex justify-content-center align-items-center  ">
                                    <img src="https://placehold.co/100x100.png" alt=""
                                        class=" img-fluid rounded ">
                                </div>

                                <h5>Tâm thanh</h5>
                                <span><i>Bánh pía nhân trứng muối rất ngon</i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="container mb-4 d-flex justify-content-center align-items-center  ">
                                    <img src="https://placehold.co/100x100.png" alt=""
                                        class=" img-fluid rounded ">
                                </div>

                                <h5>Tâm thanh</h5>
                                <span><i>Bánh pía nhân trứng muối rất ngon</i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="container mb-4 d-flex justify-content-center align-items-center  ">
                                    <img src="https://placehold.co/100x100.png" alt=""
                                        class=" img-fluid rounded ">
                                </div>

                                <h5>Tâm thanh</h5>
                                <span><i>Bánh pía nhân trứng muối rất ngon</i></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        {{-- end bình luận --}}
        <section>
            <aside class=" d-flex justify-content-between align-items-center p-0 rounded mt-4"
                style="
              width:100%;
              height:auto;
              background-color: #fff;
            
            ">
                <div class=" container title-binhluan">
                    <h5>
                        Nhà cung cấp
                    </h5>
                </div>
            </aside>
            <div class="container mt-4 p-4 ">
                <div class="row d-flex gap-3 text-center justify-content-between align-items-center">
                    <div class="col-md-3"> <img src="{{ asset('/storage/uploads/img-supliers/CLT.jpg') }}"
                            class="rounded rounded-circle " style="width:150px; height:150px;  object-fit: cover;"
                            alt="">
                    </div>
                    <div class="col-md-3"> <img src="{{ asset('/storage/uploads/img-supliers/Haison.jpg') }}"
                            class="rounded rounded-circle " style="width:150px; height:150px;  object-fit: cover;"
                            alt="">
                    </div>


                    <div class="col-md-3"> <img src="{{ asset('/storage/uploads/img-supliers/THV.jpg') }}"
                            class="rounded rounded-circle " style="width:150px; height:150px;  object-fit: cover;"
                            alt="">
                    </div>
                </div>



            </div>
        </section>
        <section>

        </section>

    </div>

@endsection
@section('scripts')
    {{-- tăng lượt view --}}
    <script>
        $(document).ready(function() {
            $('.btn-preview').on('click', function() {
                let id = $(this).data('id');
                if (id) {
                    $.ajax({
                        url: '/update-view/' + id,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                console.log('Đã cập nhật lượt xem.');
                            }
                        },
                        error: function() {
                            console.error('Lỗi cập nhật lượt xem.');
                        }
                    });
                }
            });
        });
    </script>
    {{-- tăng lượng view --}}
    {{-- đồng bộ và checklogin --}}
    <script>
        $(document).ready(function() {
            $.get('/check-login', function(res) {
                if (res.logged_in) {
                    const wishlist = getWishlist();

                    if (wishlist.length > 0) {
                        $.post('/yeuthich/sync', {
                            wishlist: wishlist,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }, function(r) {
                            if (r.success) {
                                localStorage.removeItem('data');
                                alert('Đã đồng bộ danh sách yêu thích');
                            }
                        });
                    }
                }
            });
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
                    const isFavorited = this.classList.contains('active'); // Kiểm tra class active

                    if (!isLoggedIn) {
                        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
                        const index = favorites.findIndex(item => item.id_bienthe === id_bienthe);

                        if (index === -1) {
                            favorites.push({
                                id_bienthe,
                                tensp,
                                hinh,
                                gia,
                                giakm
                            });
                            this.classList.add('active');
                            this.style.color = 'red';
                            alert('Đã thêm vào yêu thích');
                        } else {
                            favorites.splice(index, 1);
                            this.classList.remove('active');
                            this.style.color = 'gray';
                            alert('Đã xóa khỏi yêu thích');
                        }

                        localStorage.setItem('favorites', JSON.stringify(favorites));
                        document.querySelector('#favorites-count').textContent =
                            `(${favorites.length})`;
                    } else {
                        const urlAdd = document.querySelector('meta[name="yeuthich-add-url"]')
                            .getAttribute('content');
                        const urlRemove = document.querySelector('meta[name="yeuthich-remove-url"]')
                            .getAttribute('content');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');

                        fetch(isFavorited ? urlRemove : urlAdd, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    id_bienthe
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    if (isFavorited) {
                                        this.classList.remove('active');
                                        this.style.color = 'gray';
                                        alert('Đã xóa khỏi yêu thích');
                                    } else {
                                        this.classList.add('active');
                                        this.style.color = 'red';
                                        alert('Đã thêm vào yêu thích');
                                    }

                                    document.querySelector('#favorites-count').textContent =
                                        `(${data.favoritesCount})`;
                                } else {
                                    alert(data.message || 'Có lỗi xảy ra');
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert('Lỗi kết nối khi xử lý yêu thích.');
                            });
                    }
                });
            });
        });
    </script>

@endsection
<style>
    #banner-1 {
        object-fit: cover
    }

    .title>h5 {
        position: relative;
        padding-left: 20px;
        line-height: 24px;
        font-size: 24px;
        font-weight: 600;
    }

    .title>h5::before {
        position: absolute;
        content: "/";
        font-size: 24px;
        font-weight: 800;
        color: #fe9705;
        left: 0;
        top: 0;
    }

    .heart-active {
        color: linear-gradient(45deg, #4F46E5 0%, #EC4899 100%);
    }

    .title-binhluan>h5 {
        position: relative;
        padding-left: 30px;
        padding-right: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
        margin: 0;
        text-align: center;
    }

    .title-binhluan>h5::before {
        position: absolute;
        content: "";
        width: 200px;
        top: 10px;
        right: 350px;
        height: 15px;
        border-bottom: 4px solid #fe9705;
    }

    .title-binhluan>h5::after {
        position: absolute;
        content: "";
        width: 200px;
        top: 10px;
        left: 370px;
        height: 15px;
        border-bottom: 4px solid #fe9705;
    }

    .danhmuc {
        position: relative;
        display: inline-block;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .danhmuc a::before {
        position: absolute;
        content: " ";
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-left: 3px solid #fe9705;
        z-index: 1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .danhmuc:hover a::before {
        opacity: 1;
        color: #fff;
    }

    .custom-card {
        overflow: hidden;
        height: 200px;
    }

    .card-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .image-container {
        position: relative;
        overflow: hidden;
        width: 300px;
        height: 400px;
    }

    .custom-card-body:hover .card-image {
        transform: scale(1.1);
        transition: transform 0.3s ease-in-out;
    }

    .image-container::before {
        position: absolute;
        content: ' ';
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(20, 20, 20, 0.5);
    }

    .image-container::after {
        position: absolute;
        content: ' ';
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background-image: linear-gradient(to top, rgba(20, 20, 20, 0.7), rgba(20, 20, 20, 0));
    }

    .content-tong {
        position: absolute;
        top: 70%;
        left: 5%;
    }

    .content-container {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 100%;
        color: white;
        padding: 10px;
    }

    /* sản phẩm */
    .form-select {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 5px 10px;
    }

    .form-select:focus {
        border-color: #80bb35;
        box-shadow: 0 0 5px rgba(128, 187, 53, 0.5);
    }

    .product-card .product-image {
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-card:hover .btn-favorite {
        display: block !important;
        animation: fadeInRight 0.5s ease forwards;
        background-color: white !important;
        color: gray !important;
    }

    .card-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .d-flex.justify-content-between>div:first-child {
        font-size: 0.9rem;
        color: #666;
    }

    .pagination-container p {
        display: none !important;
    }


    .btn-add-to-cart {
        opacity: 0;
        transform: translateY(100%);
        transition: opacity 2s ease, transform 2s ease;
    }

    .product-card:hover .btn-add-to-cart {
        display: block !important;
        opacity: 1;
        transform: translateY(0);
    }

    .product-card:hover .product-price {
        opacity: 0;
        transition: opacity 2s ease;
    }

    .product-price {
        transition: opacity 2s ease;
    }

    .pagination-container p {
        display: none !important;
    }

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

    .pagination .page-item .page-link span {
        display: none;
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

    .product-card:hover .btn-favorite {
        display: block !important;
        animation: fadeInRight 0.5s ease forwards;
    }

    .btn-favorite:hover {
        background-color: red !important;
        color: white !important;
    }

    .product-card:hover .btn-preview {
        display: block !important;
        animation: fadeInRight 0.5s ease forwards;
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

    .btn-add-to-cart {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .product-card:hover .btn-add-to-cart {
        display: block !important;
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.5s ease forwards;
    }

    .btn-add-to-cart:hover {
        background-color: #ffe5c1 !important;
        color: black !important;
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

    .modal {
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal.show {
        display: block;
        opacity: 1;
    }

    .modal-dialog-centered {
        transform: translateY(0) !important;
        animation: none !important;
    }
</style>