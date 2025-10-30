@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Bài viết')
@section('url', route('baiviet.index'))
@section('subsubtitle', 'Bài viết chi tiết')
@section('content')
    <style>
        .post-body img {
            max-width: 100%;
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
        <div class="row g-4 g-lg-5">
            <!-- Cột trái: Nội dung bài viết -->
            <div class="col-12 col-lg-9">
                <div class="bg-white p-4 p-lg-5 rounded shadow-sm">
                    <h1 class="display-6 fw-bold text-dark mb-3">{{ $baiviet->tieude }}</h1>

                    <div
                        class="text-muted mb-4 pb-2 d-flex flex-column flex-sm-row align-items-start align-sm-center border-bottom gap-2">
                        <span class="me-4">
                            <i class="fas fa-folder me-1 text-info"></i>
                            Danh mục: <span class="badge bg-info text-dark">{{ $baiviet->danhmuc->tendm }}</span>
                        </span>
                        <span class="me-4">
                            <i class="fas fa-calendar-alt me-1 text-secondary"></i>
                            Ngày đăng: {{ $baiviet->created_at->format('d/m/Y') }}
                        </span>
                        <span class="me-4">
                            <i class="fas fa-user me-1 text-secondary"></i>
                            Tác giả: {{ $baiviet->user->hoten ?? 'Admin' }}
                        </span>
                    </div>

                    @if ($baiviet->motangan)
                        <p class="lead fst-italic border-start border-4 border-info ps-3 mb-4 text-dark">
                            {{ $baiviet->motangan }}
                        </p>
                    @endif

                    <div class="post-body text-dark" style="line-height: 1.7;">
                        {!! $baiviet->noidung !!}
                    </div>
                </div>

                <div class="d-block d-lg-none mt-4">
                    <div class="bg-white shadow-sm rounded p-3">
                        <h5 class="fw-bold mb-3">Bài viết liên quan</h5>
                        @foreach ($baivietLienQuan as $post)
                            <div class="mb-3">
                                @include('baiviet-partials.card', ['post' => $post, 'type' => 'list'])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-3 d-none d-lg-block">
                <div class="bg-white shadow-sm rounded p-3">
                    <h5 class="fw-bold mb-3">Bài viết liên quan</h5>
                    @foreach ($baivietLienQuan as $post)
                        <div class="col">
                            @include('baiviet-partials.card', ['post' => $post])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
