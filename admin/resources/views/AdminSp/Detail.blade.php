@extends('page.layout')
@section('title', 'Chi tiết sản phẩm')
@section('content')
    <div class="container-fluid p-3 p-md-3">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeInDown">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-box-seam text-danger bg-light p-4 rounded fs-4"></i>
                <div>
                    <h4 class="text-dark mb-0 fw-bold">Chi tiết sản phẩm</h4>
                    <small class="text-muted">Thông tin sản phẩm: <b class="text-primary">{{ $sanpham->tensp }}</b> (ID:
                        {{ $sanpham->id }})</small>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded animate__animated animate__bounceIn"
                role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded animate__animated animate__bounceIn"
                role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg border-0 bg-white text-dark mb-4 animate__animated animate__zoomIn">
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Cột hình ảnh -->
                    <div class="col-12 col-md-6 mb-4 d-flex flex-column align-items-center">
                        <div class="product-image-container position-relative d-flex justify-content-center overflow-hidden rounded shadow-sm"
                            style="width: 100%; max-width: 400px; object-fit: cover;">
                            @php
                                $firstBt = $sanpham->bienthe->first();
                                $mainImage =
                                    $firstBt && $firstBt->hinh
                                        ? asset('storage/' . $firstBt->hinh)
                                        : asset('storage/default.jpg');
                                $mainLabel =
                                    ($firstBt->nhanbanh->tenNhanBanh ?? 'Không nhân') .
                                    ' - ' .
                                    ($firstBt->khoiluong->khoiluong ?? 'N/A');
                            @endphp
                            <img src="{{ $mainImage }}" class="img-fluid product-image" id="main-image"
                                alt="{{ $mainLabel }}">
                            <div class="image-overlay">
                                <span class="text-white fw-semibold" id="main-image-label">{{ $mainLabel }}</span>
                            </div>
                        </div>

                        @if ($sanpham->bienthe->isNotEmpty())
                            <div class="variant-thumbnails mt-3 d-flex flex-row gap-2"
                                style="overflow-x: auto; max-width: 100%;">
                                @foreach ($sanpham->bienthe as $index => $bt)
                                    @php
                                        $thumbImage = $bt->hinh
                                            ? asset('storage/' . $bt->hinh)
                                            : asset('storage/default.jpg');
                                        $label =
                                            ($bt->nhanbanh->tenNhanBanh ?? 'Không nhân') .
                                            ' - ' .
                                            ($bt->khoiluong->khoiluong ?? 'N/A');
                                    @endphp
                                    <div class="thumbnail-wrapper position-relative overflow-hidden rounded shadow-sm {{ $index === 0 ? 'active' : '' }}"
                                        data-index="{{ $index }}" data-image="{{ $thumbImage }}"
                                        data-label="{{ $label }}">
                                        <img src="{{ $thumbImage }}" class="img-fluid thumbnail-image"
                                            alt="{{ $label }}">
                                        <div class="thumbnail-overlay">
                                            <span class="text-white fw-semibold">{{ $label }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Cột thông tin -->
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <h3 class="text-dark mb-0 fw-bold">
                                {{ $sanpham->tensp }}

                            </h3>
                        </div>
                        <p class="text-muted mb-2"><strong>Danh mục:</strong>
                            {{ $sanpham->danhmuc->tendanhmuc ?? 'Chưa có danh mục' }}</p>
                        <p class="text-muted mb-2"><strong>Nhà cung cấp:</strong>
                            {{ $sanpham->nhacungcap->tennhacungcap ?? 'Chưa có nhà cung cấp' }}</p>
                        <p class="text-muted mb-2"><strong>Số lượng:</strong> <span
                                class="{{ $total_soluong > 0 ? 'text-success' : 'text-secondary' }}">{{ $total_soluong ?? 0 }}
                                sản phẩm</span></p>
                        <p class="text-muted mb-2"><strong>Mô tả:</strong> {{ $sanpham->mota ?? 'Không có mô tả' }}</p>

                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <a href="{{ route('sanpham.edit', $sanpham->bienthe->first()->id) }}"
                                class="btn btn-warning shadow-sm btn-hover-gradient">
                                <i class="bi bi-eraser"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('sanpham.index') }}"
                                class="btn btn-outline-secondary shadow-sm btn-hover-gradient">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                        </div>

                        <div class="d-flex flex-column flex-md-row gap-2 mt-2">
                            <form action="{{ route('sanpham.softDelete', $sanpham->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger shadow-sm btn-hover-gradient"
                                    onclick="return confirm('Chuyển sản phẩm vào thùng rác?')">
                                    <i class="bi bi-trash"></i> Chuyển vào thùng rác
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mt-5" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active shadow-sm" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                            type="button" role="tab" aria-controls="info" aria-selected="true">
                            <span class="d-none d-md-inline">Thông tin chi tiết</span>
                            <span class="d-md-none">Chi tiết</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link shadow-sm" id="variant-tab" data-bs-toggle="tab" data-bs-target="#variant"
                            type="button" role="tab" aria-controls="variant" aria-selected="false">
                            <span class="d-none d-md-inline">Thông tin biến thể</span>
                            <span class="d-md-none">Biến thể</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link shadow-sm" id="additional-tab" data-bs-toggle="tab"
                            data-bs-target="#additional" type="button" role="tab" aria-controls="additional"
                            aria-selected="false">
                            <span class="d-none d-md-inline">Thông tin bổ sung</span>
                            <span class="d-md-none">Ngày</span>
                        </button>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content mt-4 p-3 bg-light rounded animate__animated animate__fadeIn"
                    id="productTabContent">
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <p><strong>ID sản phẩm:</strong> {{ $sanpham->id }}</p>
                        <p><strong>Số lượng hiện có:</strong> {{ $total_soluong ?? 0 }} sản phẩm</p>
                        <p><strong>Slug của biến thể :</strong>
                            <span class="badge bg-primary me-2 mb-1">
                                {{ $sanpham->bienthe->pluck('slug')->filter()->implode(', ') ?? 'Không có slug' }}</span>
                        </p>
                    </div>

                    <div class="tab-pane fade" id="variant" role="tabpanel" aria-labelledby="variant-tab">
                        @if ($sanpham->bienthe->isNotEmpty())
                            <p><strong>Nhân bánh:</strong>
                                {{ $sanpham->bienthe->pluck('nhanbanh.tenNhanBanh')->filter()->implode(', ') ?: 'Không có thông tin' }}
                            </p>
                            <p><strong>Khối lượng:</strong>
                                {{ $sanpham->bienthe->pluck('khoiluong.khoiluong')->filter()->implode(', ') ?: 'Không có thông tin' }}
                            </p>
                            <p><strong>Số lượng từng biến thể:</strong><br>
                                @foreach ($sanpham->bienthe as $bt)
                                    @php
                                        $nhanbanh = $bt->nhanbanh ? $bt->nhanbanh->tenNhanBanh : 'Không nhân';
                                        $khoiluong = $bt->khoiluong ? $bt->khoiluong->khoiluong : 'N/A';
                                    @endphp
                                    <span class="badge bg-primary me-2 mb-2">{{ $nhanbanh }} -
                                        {{ $khoiluong }}:
                                        {{ $bt->soluong }} cái</span>
                                @endforeach
                            </p>
                        @else
                            <p>Chưa có thông tin biến thể</p>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                        <p><strong>Ngày tạo:</strong> {{ $sanpham->created_at->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Cập nhật:</strong> {{ $sanpham->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                    <p><strong>Ngày thêm:</strong> {{ $sanpham->created_at->format('d/m/Y') }}</p>
                    <p><strong>Cập nhật lần cuối:</strong> {{ $sanpham->updated_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.thumbnail-wrapper');
            const mainImage = document.getElementById('main-image');
            const mainImageLabel = document.getElementById('main-image-label');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Xóa lớp active khỏi tất cả thumbnail
                    thumbnails.forEach(t => t.classList.remove('active'));
                    // Thêm lớp active cho thumbnail được nhấn
                    this.classList.add('active');

                    // Cập nhật hình ảnh chính và nhãn
                    const imageUrl = this.getAttribute('data-image');
                    const label = this.getAttribute('data-label');
                    mainImage.src = imageUrl;
                    mainImage.alt = label;
                    mainImageLabel.textContent = label;
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 15px;
            transition: transform 0.3s ease;
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
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
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

        .btn-hover-gradient {
            transition: all 0.3s ease;
        }

        .btn-hover-gradient:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-secondary {
            border-color: #6c757d;
        }

        .btn-warning {
            background: linear-gradient(45deg, #ffca28, #ffb300);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(45deg, #ef5350, #d32f2f);
            border: none;
        }

        .nav-tabs .nav-link {
            border-radius: 10px 10px 0 0;
            margin-right: 5px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background: #007bff;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.3);
        }

        .nav-tabs .nav-link:hover {
            background: #f8f9fa;
            color: #000;
        }

        .tab-content {
            border-radius: 0 10px 10px 10px;
        }

        .badge-custom {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 20px;
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

            .nav-tabs .nav-link {
                padding: 8px 12px;
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
            }
        }
    </style>
@endsection
