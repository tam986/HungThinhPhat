@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Cửa hàng')
@section('subsubtitle', 'Sản phẩm chi tiết')
@section('content')
    <div class="row bg-light border-0 shadow-sm rounded ">
        <div class="col-md-6 position-relative p-4">
            <div class="product-image-container position-relative d-flex justify-content-center overflow-hidden rounded shadow-sm"
                style="width: 100%; max-width: 400px; object-fit: cover; height: 400px;">
                <img src="{{ config('app.cms_url') . '/storage/' . ($selectedBienthe->hinh ?? $selectedBienthe->sanpham->hinh) }}"
                    class="img-fluid rounded shadow-sm product-image" id="main-image" alt=""
                    style="height: 400px; object-fit: cover; width: 100%;">
                <div class="image-overlay">
                    <span class="text-white fw-semibold" id="main-image-label">
                        {{ $selectedBienthe->nhanbanh->tenNhanBanh ?? 'không có' }} -
                        {{ $selectedBienthe->khoiluong->khoiluong ?? 'không có' }}g
                    </span>
                </div>
            </div>

            <!-- Danh sách ảnh thumbnail của biến thể -->
            @php
                $variants = \App\Models\Bienthe::where('id_sp', $selectedBienthe->sanpham->id)->get();
            @endphp
            @if ($variants->isNotEmpty())
                <div class="variant-thumbnails mt-3 d-flex flex-row gap-2"
                    style="overflow-x: auto; max-width: 100%;">
                    @foreach ($variants as $index => $bt)
                        @php
                            $thumbImage = $bt->hinh
                                ? config('app.cms_url') . '/storage/' . $bt->hinh
                                : config('app.cms_url') . '/storage/' . $selectedBienthe->sanpham->hinh;
                            $label =
                                ($bt->nhanbanh->tenNhanBanh ?? 'không có') .
                                ' - ' .
                                ($bt->khoiluong->khoiluong ?? 'không có') . 'g';
                        @endphp
                        <div class="thumbnail-wrapper position-relative overflow-hidden rounded shadow-sm {{ $bt->id === $selectedBienthe->id ? 'active' : '' }}"
                            data-index="{{ $index }}"
                            data-image="{{ $thumbImage }}"
                            data-label="{{ $label }}"
                            data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                            <img src="{{ $thumbImage }}" class="img-fluid thumbnail-image"
                                alt="{{ $label }}">
                            <div class="thumbnail-overlay">
                                <span class="text-white fw-semibold">{{ $label }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="container mt-3">
                <div class="row">
                    @foreach ($selectedBienthe->sanpham->thuvienhinhanh ?? [] as $img)
                        <div class="col-sm-3">
                            @if ($selectedBienthe->slug)
                                <a href="{{ route('sanpham.detail', $selectedBienthe->slug) }}">
                                    <img src="{{ config('app.cms_url') . '/storage/' . $img->url }}"
                                        class="img-thumbnail" alt="Hình phụ">
                                </a>
                            @else
                                <img src="{{ config('app.cms_url') . '/storage/' . $img->url }}"
                                    class="img-thumbnail" alt="Hình phụ">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6 p-4">
            <h2>{{ $selectedBienthe->sanpham->tensp }}</h2>
            <p class="text-muted mb-1">
                <b>Nhân bánh - Khối lượng:</b>
                <span id="variant-label">
                    {{ $selectedBienthe->nhanbanh->tenNhanBanh ?? 'không có' }} -
                    {{ $selectedBienthe->khoiluong->khoiluong ?? 'không có' }}g
                </span>
            </p>
            <p class="text-muted mb-1"><b>Số lượng còn:</b> <span id="stock">{{ $selectedBienthe->soluong }}</span></p>
            <h5 class="mb-1">
                <span class="text-danger" id="price">{{ number_format($selectedBienthe->gia) }} đ</span>
            </h5>
            <p class="text-muted mb-3">
                <b>Mô tả:</b> {{ $selectedBienthe->sanpham->mota ?? 'Không có mô tả.' }}
            </p>

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

            <form id="formAddToCart" method="POST" action="{{ route('cart.add') }}">
                @csrf
                <!-- Input chọn biến thể -->
                <div class="d-flex align-items-center mb-3">
                    <label class="me-3"><b>Biến thể:</b></label>
                    <select name="id_bienthe" id="variantSelect" class="form-select" style="width: 120px; height: 38px; font-size: 14px;">
                        @foreach ($variants as $bt)
                            @php
                                $label = ($bt->nhanbanh->tenNhanBanh ?? 'không có') . ' - ' . ($bt->khoiluong->khoiluong ?? 'không có') . 'g';
                            @endphp
                            <option value="{{ $bt->id }}"
                                data-image="{{ $bt->hinh ? config('app.cms_url') . '/storage/' . $bt->hinh : config('app.cms_url') . '/storage/' . $selectedBienthe->sanpham->hinh }}"
                                data-label="{{ $label }}"
                                data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                data-stock="{{ $bt->soluong }}"
                                data-price="{{ $bt->gia }}"
                                {{ $bt->id == $selectedBienthe->id ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input số lượng -->
                <div class="d-flex align-items-center mb-3">
                    <label class="me-3"><b>Số lượng:</b></label>
                    <div class="input-group" style="width: 120px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
                        <input id="qtyInput" name="soluong" type="text" class="form-control text-center" value="1"
                            min="1" max="{{ $selectedBienthe->soluong }}">
                        <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary ms-3" style="background-color: #fe9705; border: none;">
                        Thêm vào giỏ
                    </button>
                </div>
            </form>

            <form id="formFavorite" method="POST" action="{{ route('yeuthich.add') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $selectedBienthe->id }}">
                <input type="hidden" name="sanpham_id" value="{{ $selectedBienthe->sanpham->id }}">
                <input type="hidden" name="ten" value="{{ $selectedBienthe->sanpham->tensp }}">
                <input type="hidden" name="hinhanh"
                    value="{{ $selectedBienthe->hinh ?? $selectedBienthe->sanpham->hinh }}">
                <input type="hidden" name="gia" value="{{ $selectedBienthe->gia }}">
                <div class="d-flex gap-3 mb-3">
                    <button class="btn btn-outline-secondary btn-favorite"
                        style="background-color: transparent; border: 1px solid #ced4da;">
                        <i class="bi bi-heart"></i> Thêm vào yêu thích
                    </button>
                </div>
            </form>

            <p class="text-muted mt-3"><b>Danh mục:</b>
                {{ $selectedBienthe->sanpham->danhmuc->tendanhmuc ?? 'Không có danh mục' }}
            </p>
            <p class="text-muted"><b>Nhà cung cấp:</b>
                {{ $selectedBienthe->sanpham->nhacungcap->tennhacungcap ?? 'Không có nhà cung cấp' }}
            </p>
        </div>
    </div>

    <div class="mt-5 bg-light p-4 shadow-0 border-0 rounded">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                    type="button" role="tab" aria-controls="description" aria-selected="true">Mô tả</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                    role="tab" aria-controls="reviews" aria-selected="false">Đánh giá
                    ({{ $selectedBienthe->binhluans()->where('trangthai', 'đã duyệt')->count() }})</button>
            </li>
        </ul>
        <div class="tab-content" id="productTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <p class="mt-3">{{ $selectedBienthe->sanpham->mota ?? 'Không có mô tả.' }}</p>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="mt-3">
                    @if (Auth::check())
                        @php
                            $hasPurchased = \App\Models\Donhang::where('id_user', Auth::id())
                                ->whereHas('donhangchitiet', function ($query) use ($selectedBienthe) {
                                    $query->where('id_bienthe', $selectedBienthe->id);
                                })
                                ->where('trangthai', 'hoàn thành')
                                ->exists();
                        @endphp
                        @if ($hasPurchased)
                            <form method="POST" action="{{ route('binhluan.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="noidung" class="form-label"><b>Viết bình luận của bạn:</b></label>
                                    <textarea class="form-control" id="noidung" name="noidung" rows="4" required></textarea>
                                    <input type="hidden" name="id_bienthe" value="{{ $selectedBienthe->id }}">
                                </div>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #fe9705; border: none;">Gửi bình luận</button>
                            </form>
                        @else
                            <p class="text-muted">Bạn cần mua sản phẩm này để có thể bình luận.</p>
                        @endif
                    @else
                        <p class="text-muted">Vui lòng <a href="{{ route('login.form') }}">đăng nhập</a> để bình luận.
                        </p>
                    @endif

                    <hr class="my-4">

                    <h5>Bình luận</h5>
                    @php
                        $comments = $selectedBienthe->binhluans()->with('user')->get();
                    @endphp
                    @forelse ($comments as $comment)
                        <div class="comment mb-3 p-3 border rounded"
                            style="{{ $comment->trangthai === 'chờ duyệt' ? 'filter: blur(4px);' : '' }}">
                            <p><strong>{{ $comment->user->hoten }}</strong> <small
                                    class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small></p>
                            <p>{{ $comment->noidung }}</p>
                            @if ($comment->trangthai === 'chờ duyệt')
                                <p class="text-warning"><small>Bình luận đang chờ duyệt</small></p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Chưa có bình luận nào.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 bg-light rounded d-flex justify-content-between align-items-center p-0 mb-4">
        <div class="container title">
            <h5>Sản phẩm liên quan</h5>
        </div>
        <div class="rounded p-2" style="background-color:#fe9705;">
            <button type="button" class="btn" style="width:100px;">Xem thêm</button>
        </div>
    </div>

    <div class="row p-4">
        @php
            $relatedProducts = [];
            $count = 0;
            foreach ($sanphamTuongtu as $sp) {
                if ($count >= 4) {
                    break;
                }
                $bienthe = \App\Models\Bienthe::with(['khoiluong', 'nhanbanh'])
                    ->where('id_sp', $sp->id)
                    ->get();
                if ($bienthe->isNotEmpty()) {
                    foreach ($bienthe as $bt) {
                        if ($count >= 4) {
                            break;
                        }
                        $relatedProducts[] = ['sanpham' => $sp, 'bienthe' => $bt];
                        $count++;
                    }
                } else {
                    $relatedProducts[] = ['sanpham' => $sp, 'bienthe' => null];
                    $count++;
                }
            }
        @endphp

        @forelse ($relatedProducts as $item)
            @php
                $sp = $item['sanpham'];
                $bt = $item['bienthe'];
            @endphp
            @if ($bt)
                <div class="col-12 col-md-3 mb-4 product-item" data-price="{{ $bt->gia ?? 0 }}">
                    <div class="card h-100 product-card">
                        <div class="position-relative overflow-hidden">
                            <a href="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}">
                                <img src="{{ config('app.cms_url') . '/storage/' . ($bt->hinh ?? $sp->hinh) }}"
                                    class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                    style="height: 200px; object-fit: cover;">
                            </a>
                            <button class="btn btn-preview position-absolute"
                                style="top: 10px; right: 10px; background-color: white; color: gray; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                data-bs-toggle="modal"
                                data-bs-target="#relatedProductModal{{ $sp->id }}_{{ $bt->id }}">
                                <i class="bi bi-arrows-angle-expand"></i>
                            </button>
                            <button data-id="{{ $bt->id }}"
                                data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                data-gia="{{ $bt->gia ?? 0 }}" data-image="{{ $bt->hinh ?? $sp->hinh }}"
                                data-name="{{ $sp->tensp }}" class="btn btn-favorite position-absolute btn-wishlist"
                                style="top: 60px; right: 10px; background-color: white; color: gray; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <div class="product-info flex-grow-1">
                                <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
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
                            <p class="card-text text-danger mb-3">
                                {{ number_format($bt->gia ?? 0) }} đ
                            </p>
                            <form method="POST" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="id_bienthe" value="{{ $bt->id }}">
                                <input type="hidden" name="soluong" value="1">
                                <button type="submit" class="btn btn-primary btn-add-to-cart w-100"
                                    style="background-color: #fe9705; border: none; border-radius: 25px; padding: 8px 0;">
                                    Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="relatedProductModal{{ $sp->id }}_{{ $bt->id }}" tabindex="-1"
                    aria-labelledby="relatedProductModalLabel{{ $sp->id }}_{{ $bt->id }}"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="relatedProductModalLabel{{ $sp->id }}_{{ $bt->id }}">
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
                                            <img src="{{ config('app.cms_url') . '/storage/' . ($bt->hinh ?? $sp->hinh) }}"
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
                                            <span class="text-danger">{{ number_format($bt->gia ?? 0) }} đ</span>
                                        </h5>
                                        <p class="text-muted mb-3">
                                            <b>Mô tả:</b> {{ $sp->mota ?? 'Không có mô tả.' }}
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
                                                data-url="{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}"
                                                data-gia="{{ $bt->gia ?? 0 }}" data-image="{{ $bt->hinh ?? $sp->hinh }}"
                                                data-name="{{ $sp->tensp }}"
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
            @else
                <div class="col-6 col-md-3 mb-4 product-item" data-price="0">
                    <div class="card h-100 product-card">
                        <div class="position-relative overflow-hidden">
                            <a href="{{ route('sanpham.detail', $sp->id) }}">
                                <img src="{{ config('app.cms_url') . '/storage/' . $sp->hinh }}" class="card-img-top product-image"
                                    alt="{{ $sp->tensp }}" style="height: 200px; object-fit: cover;">
                            </a>
                            <button class="btn btn-preview position-absolute"
                                style="top: 10px; right: 10px; background-color: white; color: gray; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                data-bs-toggle="modal" data-bs-target="#relatedProductModal{{ $sp->id }}_default">
                                <i class="bi bi-arrows-angle-expand"></i>
                            </button>
                            <button data-id="0" data-url="{{ route('sanpham.detail', $sp->id) }}" data-gia="0"
                                data-image="{{ $sp->hinh }}" data-name="{{ $sp->tensp }}"
                                class="btn btn-favorite position-absolute btn-wishlist"
                                style="top: 60px; right: 10px; background-color: white; color: gray; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <div class="product-info flex-grow-1">
                                <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
                                    <h6 class="card-text mb-0" style="height: 50px;">
                                        <a href="{{ route('sanpham.detail', $sp->id) }}"
                                            class="text-decoration-none text-dark">{{ $sp->tensp }}</a>
                                    </h6>
                                </div>
                                <p class="card-text text-muted mb-1">Không có biến thể</p>
                                <p class="card-text text-muted mb-2">Số lượng còn: 0</p>
                            </div>
                            <p class="card-text text-danger mb-3">Không có giá</p>
                            <button class="btn btn-primary btn-add-to-cart w-100"
                                style="background-color: #fe9705; border: none; border-radius: 25px; padding: 8px 0;"
                                disabled>
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="relatedProductModal{{ $sp->id }}_default" tabindex="-1"
                    aria-labelledby="relatedProductModalLabel{{ $sp->id }}_default" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="relatedProductModalLabel{{ $sp->id }}_default">
                                    {{ $sp->tensp }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('sanpham.detail', $sp->id) }}">
                                            <img src="{{ config('app.cms_url') . '/storage/' . $sp->hinh }}"
                                                class="card-img-top product-image" alt="{{ $sp->tensp }}"
                                                style="height: 200px; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>{{ $sp->tensp }}</h4>
                                        <p class="text-muted mb-1">Không có biến thể</p>
                                        <p class="text-muted mb-1">Số lượng còn: 0</p>
                                        <h5 class="mb-1">
                                            <span class="text-danger">Không có giá</span>
                                        </h5>
                                        <p class="text-muted mb-3">
                                            <b>Mô tả:</b> {{ $sp->mota ?? 'Không có mô tả.' }}
                                        </p>
                                        <button class="btn btn-primary" style="background-color: #fe9705; border: none;"
                                            disabled>
                                            Thêm vào giỏ
                                        </button>
                                        <div class="d-flex gap-3 mt-3">
                                            <button data-id="0" data-url="{{ route('sanpham.detail', $sp->id) }}"
                                                data-gia="0" data-image="{{ $sp->hinh }}"
                                                data-name="{{ $sp->tensp }}"
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
            @endif
        @empty
            <div class="col-12 text-center">
                <p>Không có sản phẩm tương tự.</p>
            </div>
        @endforelse
    </div>
@endsection

<script>
    function changeQty(change) {
        const input = document.getElementById('qtyInput');
        let current = parseInt(input.value);
        const max = parseInt(input.max);
        if (!isNaN(current)) {
            current = current + change;
            if (current < 1) current = 1;
            if (current > max) current = max;
            input.value = current;
        }
    }

    // Dữ liệu biến thể
    const variants = [
        @foreach ($variants as $bt)
            {
                id: {{ $bt->id }},
                image: "{{ $bt->hinh ? config('app.cms_url') . '/storage/' . $bt->hinh : config('app.cms_url') . '/storage/' . $selectedBienthe->sanpham->hinh }}",
                label: "{{ ($bt->nhanbanh->tenNhanBanh ?? 'không có') . ' - ' . ($bt->khoiluong->khoiluong ?? 'không có') . 'g' }}",
                url: "{{ $bt->slug ? route('sanpham.detail', $bt->slug) : '#' }}",
                stock: {{ $bt->soluong }},
                price: {{ $bt->gia }},
            },
        @endforeach
    ];

    function changeVariant(change) {
        const variantIndexInput = document.getElementById('variantIndex');
        let currentIndex = parseInt(variantIndexInput.value);
        const maxIndex = variants.length - 1;

        currentIndex = currentIndex + change;
        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex > maxIndex) currentIndex = maxIndex;

        variantIndexInput.value = currentIndex;

        const selectedVariant = variants[currentIndex];
        const mainImage = document.getElementById('main-image');
        const mainImageLabel = document.getElementById('main-image-label');
        const variantLabel = document.getElementById('variant-label');
        const stockDisplay = document.getElementById('stock');
        const priceDisplay = document.getElementById('price');
        const qtyInput = document.getElementById('qtyInput');
        const idBientheInput = document.getElementById('id_bienthe');

        // Cập nhật thông tin biến thể
        mainImage.src = selectedVariant.image;
        mainImage.alt = selectedVariant.label;
        mainImageLabel.textContent = selectedVariant.label;
        variantLabel.textContent = selectedVariant.label;
        stockDisplay.textContent = selectedVariant.stock;
        priceDisplay.textContent = Number(selectedVariant.price).toLocaleString() + ' đ';
        qtyInput.max = selectedVariant.stock;
        idBientheInput.value = selectedVariant.id;

        // Cập nhật URL của form yêu thích
        const formFavorite = document.getElementById('formFavorite');
        formFavorite.querySelector('input[name="id"]').value = selectedVariant.id;
        formFavorite.querySelector('input[name="gia"]').value = selectedVariant.price;
        formFavorite.querySelector('input[name="hinhanh"]').value = selectedVariant.image.split('/storage/')[1];

        // Chuyển hướng đến URL của biến thể
        if (selectedVariant.url !== '#') {
            window.location.href = selectedVariant.url;
        }
    }
</script>

@section('scripts')
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

            // Xử lý khi nhấn vào thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail-wrapper');
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Xóa lớp active khỏi tất cả thumbnail
                    thumbnails.forEach(t => t.classList.remove('active'));
                    // Thêm lớp active cho thumbnail được nhấn
                    this.classList.add('active');

                    // Cập nhật hình ảnh chính và nhãn
                    const imageUrl = this.getAttribute('data-image');
                    const label = this.getAttribute('data-label');
                    const mainImage = document.getElementById('main-image');
                    const mainImageLabel = document.getElementById('main-image-label');
                    mainImage.src = imageUrl;
                    mainImage.alt = label;
                    mainImageLabel.textContent = label;

                    // Chuyển hướng đến URL của biến thể
                    const url = this.getAttribute('data-url');
                    if (url !== '#') {
                        window.location.href = url;
                    }
                });
            });
        });

        function getWishlist() {
            return JSON.parse(localStorage.getItem('data')) || [];
        }

        function setWishlist(list) {
            localStorage.setItem('data', JSON.stringify(list));
        }

        $(document).on('click', '.btn-wishlist', function() {
            const id_bienthe = $(this).data('id');
            const url = $(this).data('url');
            const gia = $(this).data('gia');
            const name = $(this).data('name');
            const image = $(this).data('image');

            $.get('/check-login', function(res) {
                if (res.logged_in) {
                    $.post('/yeuthich/active', {
                        id_bienthe: id_bienthe,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function(r) {
                        alert(r.message);
                    });
                } else {
                    let wishlist = getWishlist();
                    const exists = wishlist.find(item => item.id_bienthe == id_bienthe);
                    if (exists) {
                        alert('Sản phẩm đã có trong danh sách yêu thích');
                    } else {
                        if (wishlist.length >= 10) {
                            alert('Vui lòng đăng nhập để lưu thêm sản phẩm!');
                            return;
                        }
                        wishlist.push({
                            id_bienthe,
                            url,
                            gia,
                            name,
                            image
                        });
                        setWishlist(wishlist);
                        alert('Đã thêm vào danh sách yêu thích');
                    }
                }
            });
        });
    </script>
@endsection

<style>
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
</style>

@section('styles')
    <style>
        .product-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            background-color: #fff;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-card .product-image {
            transition: transform 0.3s ease;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .product-card:hover .product-image {
            transform: scale(1.1);
        }

        .btn-favorite:hover {
            background-color: red;
            color: white;
        }

        .btn-preview:hover {
            background-color: #80bb35;
            color: white;
        }

        .btn-add-to-cart:hover {
            background-color: #ffe5c1;
            color: black;
        }

        .product-info {
            transition: filter 0.3s ease;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-body .text-danger {
            font-weight: bold;
            font-size: 1.1rem;
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

        .nav-tabs .nav-link {
            color: #666;
            border: none;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #fe9705;
            border-bottom: 2px solid #fe9705;
        }

        .nav-tabs .nav-link:hover {
            color: #fe9705;
            border-bottom: 2px solid #fe9705;
        }

        .form-control,
        .form-check-input {
            border-radius: 5px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #fe9705;
            box-shadow: 0 0 5px rgba(254, 151, 5, 0.3);
        }

        .form-check-input:checked {
            background-color: #fe9705;
            border-color: #fe9705;
        }

        /* CSS cho danh sách thumbnail */
        .variant-thumbnails {
            max-width: 400px;
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: thin;
            scrollbar-color: #6c757d #f8f9fa;
        }

        .variant-thumbnails::-webkit-scrollbar {
            height: 6px;
        }

        .variant-thumbnails::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .variant-thumbnails::-webkit-scrollbar-thumb {
            background: #6c757d;
            border-radius: 10px;
        }

        .thumbnail-wrapper {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .thumbnail-wrapper.active {
            border-color: #fe9705;
            box-shadow: 0 0 8px rgba(254, 151, 5, 0.3);
        }

        .thumbnail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .thumbnail-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 8px;
        }

        .thumbnail-wrapper:hover .thumbnail-overlay {
            opacity: 1;
        }

        .product-image-container {
            max-width: 100%;
            transition: all 0.3s ease;
        }

        .product-image {
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 10px;
        }

        .product-image-container:hover .image-overlay {
            opacity: 1;
        }

        .product-image-container:hover .product-image {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .product-image {
                max-height: 250px;
                object-fit: cover;
            }

            .variant-thumbnails {
                max-width: 100%;
            }

            .thumbnail-wrapper {
                width: 50px;
                height: 50px;
            }
        }
    </style>
@endsection