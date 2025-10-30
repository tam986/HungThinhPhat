@extends('page.layout')

@section('content')
    <style>
        .post-body img {
            max-width: 800px;
            height: auto;
            border-radius: var(--bs-border-radius, 0.25rem);
            margin-top: 1rem;
            margin-bottom: 1rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
            box-shadow: var(--bs-box-shadow-sm);
        }
    </style>
    <div class="container my-4 my-md-5">

        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h2 class="mb-0 text-dark">Chi Tiết Bài Viết</h2>
            <div class="actions">
                <a href="{{ route('baiviet.edit', $baiViet->id) }}" class="btn btn-primary btn-sm shadow-sm me-2">
                    <i class="fas fa-edit me-1"></i> Chỉnh sửa
                </a>
            </div>
        </div>

        <div class="bg-white p-4 p-lg-5 rounded shadow-sm">
            <div class="row g-4 g-lg-5">

                <div class="col-md-3">
                    <h1 class="display-6 fw-bold text-dark mb-3">{{ $baiViet->tieude }}</h1>
                    @if ($baiViet->anhdaidien)
                        <div class="featured-image-wrapper position-sticky" style="top: 2rem;">
                            <img src="{{ asset('storage/' . $baiViet->anhdaidien) }}"
                                alt="Ảnh đại diện bài viết: {{ $baiViet->tieude }}"
                                class="img-fluid rounded shadow-sm w-100">
                        </div>
                    @else
                        <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="text-muted mb-4 pb-2 d-flex align-items-center border-bottom">
                        <span class="me-4">
                            <i class="fas fa-folder me-1 text-info"></i>
                            Danh mục: <span class="badge bg-info text-dark">{{ $baiViet->danhmucbaiviet->tendm }}</span>
                        </span>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="text-muted mb-4 pb-2 d-flex align-items-center border-bottom">
                        <span class="me-4">
                            <i class="fas fa-calendar-alt me-1 text-secondary"></i>
                            Ngày đăng: {{ $baiViet->created_at->format('d/m/Y') }}
                        </span>
                        <span class="me-4">
                            <i class="fas fa-user me-1 text-secondary"></i>
                            Tác giả: {{ $baiViet->user->hoten ?? 'Admin' }}
                        </span>
                    </div>
                    @if ($baiViet->motangan)
                        <p class="lead fst-italic border-start border-4 border-info ps-3 mb-4 text-dark">
                            {{ $baiViet->motangan }}
                        </p>
                    @endif
                    <div class="post-body text-dark" style="line-height: 1.7;">
                        {!! $baiViet->noidung !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 pt-3 border-top text-start">
            <a href="{{ route('baiviet.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>
@endsection
