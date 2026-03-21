@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Bài viết')

@section('content')
    <div class="container my-4">

        <form action="{{ route('baiviet.search') }}" method="GET" class="baiviet-search-form mb-4 d-flex gap-2 flex-column flex-md-row align-items-stretch">
            <input type="hidden" name="danhmuc" value="{{ $danhmucChon->id ?? '' }}">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm bài viết..."
                class="form-control flex-grow-1">
            <button type="submit" class="btn text-white flex-shrink-0" style="background-color: orange; border: none;">
                Tìm
            </button>
        </form>

        <section class="mb-5">
            <aside class="section-title-aside bg-white rounded mt-4 p-3">
                <div class="section-title-text">
                    <h5>Bài viết mới</h5>
                </div>
            </aside>

            <div class="mt-4 rounded overflow-hidden" style="background-color: var(--bs-light);">
                <div id="carouselNewArticles" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3800">
                    <div class="carousel-inner">
                        @foreach ($baivietMoi->chunk(4) as $index => $chunk)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="row g-4 p-4">
                                    @foreach ($chunk as $baiviet)
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <a href="{{ route('baiviet.show', $baiviet->slug) }}" class="card-link text-decoration-none">
                                                <div class="card h-100 custom-card">
                                                    <div class="image-container">
                                                        <img src="{{ config('app.cms_url') . '/storage/' . $baiviet->anhdaidien }}"
                                                            class="card-img-top card-image" alt="{{ $baiviet->tieude ?? 'Ảnh bài viết' }}" />
                                                        <div class="content-overlay">
                                                             <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                                 @if($baiviet->danhmuc)
                                                                    <div class="badge bg-orange text-white">{{ $baiviet->danhmuc->tendm }}</div>
                                                                 @endif
                                                                 <div class="text-white small">👁️ {{ $baiviet->luotxem ?? 0 }}</div>
                                                             </div>
                                                             <div>
                                                                 <h6 class="card-title text-white">{{ \Illuminate\Support\Str::limit($baiviet->tieude, 50) }}</h6>
                                                                 <p class="text-white-50 small mb-0">{{ $baiviet->created_at->format('d/m/Y') }}</p>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselNewArticles" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselNewArticles" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>

         <section class="mb-5">
            <aside class="section-title-aside bg-white rounded mt-4 p-3">
                <div class="section-title-text">
                    <h5>Bài viết xem nhiều</h5>
                </div>
            </aside>
            <div class="mt-4 rounded overflow-hidden" style="background-color: var(--bs-light);">
                <div class="row g-4 p-4">
                    @foreach ($baivietXemNhieu as $baiviet)
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="{{ route('baiviet.show', $baiviet->slug) }}" class="card-link text-decoration-none">
                                 <div class="card h-100 custom-card">
                                     <div class="image-container">
                                        <img src="{{ config('app.cms_url') . '/storage/' . $baiviet->anhdaidien }}"
                                            class="card-img-top card-image" alt="{{ $baiviet->tieude ?? 'Ảnh bài viết' }}" />
                                        <div class="content-overlay">
                                             <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                 @if($baiviet->danhmuc)
                                                    <div class="badge bg-orange text-white">{{ $baiviet->danhmuc->tendm }}</div>
                                                 @endif
                                                 <div class="text-white small">👁️ {{ $baiviet->luotxem ?? 0 }}</div>
                                             </div>
                                             <div>
                                                 <h6 class="card-title text-white">{{ \Illuminate\Support\Str::limit($baiviet->tieude, 50) }}</h6>
                                                 <p class="text-white-50 small mb-0">{{ $baiviet->created_at->format('d/m/Y') }}</p>
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

        <section class="mb-5">
            <div class="row g-4">

                <div class="col-md-9">

                    <section class="mb-4">
                         <aside class="section-title-aside bg-white rounded p-3">
                            <div class="section-title-text">
                                <h5>{{ $danhmucTinTuc->tendm }}</h5>
                            </div>
                            <div class="view-more-btn-container">
                                <a href="{{ route('baiviet.danhmuc', ['id' => $danhmucTinTuc->id]) }}"
                                    class="btn btn-sm btn-warning text-white">Xem thêm</a>
                            </div>
                        </aside>
                        <div class="mt-4 rounded overflow-hidden" style="background-color: var(--bs-light);">
                            <div class="row g-4 p-4">
                                @forelse ($baivietTintuc as $baiviet)
                                    <div class="col-12 col-sm-6 col-md-4">
                                         <a href="{{ route('baiviet.show', $baiviet->slug) }}" class="card-link text-decoration-none">
                                            <div class="card h-100 custom-card">
                                                 <div class="image-container">
                                                    <img src="{{ config('app.cms_url') . '/storage/' . $baiviet->anhdaidien }}"
                                                        class="card-img-top card-image" alt="{{ $baiviet->tieude ?? 'Ảnh bài viết' }}" />
                                                    <div class="content-overlay">
                                                         <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                             @if($baiviet->danhmuc)
                                                                <div class="badge bg-orange text-white">{{ $baiviet->danhmuc->tendm }}</div>
                                                             @endif
                                                             <div class="text-white small">👁️ {{ $baiviet->luotxem ?? 0 }}</div>
                                                         </div>
                                                         <div>
                                                             <h6 class="card-title text-white">{{ \Illuminate\Support\Str::limit($baiviet->tieude, 50) }}</h6>
                                                             <p class="text-white-50 small mb-0">{{ $baiviet->created_at->format('d/m/Y') }}</p>
                                                         </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12 text-center p-4">
                                        <h3 class="text-muted">Chưa có bài viết nào</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                     <section class="mb-4">
                         <aside class="section-title-aside bg-white rounded p-3">
                            <div class="section-title-text">
                                <h5>{{ $danhmucDuLich->tendm }}</h5>
                            </div>
                            <div class="view-more-btn-container">
                                <a href="{{ route('baiviet.danhmuc', ['id' => $danhmucDuLich->id]) }}"
                                    class="btn btn-sm btn-warning text-white">Xem thêm</a>
                            </div>
                        </aside>
                        <div class="mt-4 rounded overflow-hidden" style="background-color: var(--bs-light);">
                             <div class="row g-4 p-4">
                                @foreach ($baivietDulich as $baiviet)
                                    <div class="col-12 col-sm-6 col-md-4">
                                         <a href="{{ route('baiviet.show', $baiviet->slug) }}" class="card-link text-decoration-none">
                                            <div class="card h-100 custom-card">
                                                 <div class="image-container">
                                                    <img src="{{ config('app.cms_url') . '/storage/' . $baiviet->anhdaidien }}"
                                                        class="card-img-top card-image" alt="{{ $baiviet->tieude ?? 'Ảnh bài viết' }}" />
                                                     <div class="content-overlay">
                                                         <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                             @if($baiviet->danhmuc)
                                                                <div class="badge bg-orange text-white">{{ $baiviet->danhmuc->tendm }}</div>
                                                             @endif
                                                             <div class="text-white small">👁️ {{ $baiviet->luotxem ?? 0 }}</div>
                                                         </div>
                                                         <div>
                                                             <h6 class="card-title text-white">{{ \Illuminate\Support\Str::limit($baiviet->tieude, 50) }}</h6>
                                                             <p class="text-white-50 small mb-0">{{ $baiviet->created_at->format('d/m/Y') }}</p>
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

                     <section class="mb-4">
                         <aside class="section-title-aside bg-white rounded p-3">
                            <div class="section-title-text">
                                <h5>{{ $danhmucAmthuc->tendm }}</h5>
                            </div>
                             <div class="view-more-btn-container">
                                <a href="{{ route('baiviet.danhmuc', ['id' => $danhmucAmthuc->id]) }}"
                                    class="btn btn-sm btn-warning text-white">Xem thêm</a>
                            </div>
                        </aside>
                         <div class="mt-4 rounded overflow-hidden" style="background-color: var(--bs-light);">
                            <div class="row g-4 p-4">
                                @foreach ($baivietAmthuc as $baiviet)
                                    <div class="col-12 col-sm-6 col-md-4">
                                         <a href="{{ route('baiviet.show', $baiviet->slug) }}" class="card-link text-decoration-none">
                                            <div class="card h-100 custom-card">
                                                 <div class="image-container">
                                                    <img src="{{ config('app.cms_url') . '/storage/' . $baiviet->anhdaidien }}"
                                                        class="card-img-top card-image" alt="{{ $baiviet->tieude ?? 'Ảnh bài viết' }}" />
                                                     <div class="content-overlay">
                                                         <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                             @if($baiviet->danhmuc)
                                                                <div class="badge bg-orange text-white">{{ $baiviet->danhmuc->tendm }}</div>
                                                             @endif
                                                             <div class="text-white small">👁️ {{ $baiviet->luotxem ?? 0 }}</div>
                                                         </div>
                                                         <div>
                                                             <h6 class="card-title text-white">{{ \Illuminate\Support\Str::limit($baiviet->tieude, 50) }}</h6>
                                                             <p class="text-white-50 small mb-0">{{ $baiviet->created_at->format('d/m/Y') }}</p>
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

                </div>

                <div class="col-md-3">
                    <aside class="section-title-aside bg-white rounded p-3 mt-4 mt-md-0">
                        <div class="section-title-text">
                            <h5>Danh mục</h5>
                        </div>

                    </aside>
                    <div class="card mt-4 border-0 shadow-sm">
                        <div class="card-body p-3">
                            <ol class="list-group list-group-numbered">
                                @foreach ($danhmuc as $dm)
                                    <li class="list-group-item d-flex border-0 justify-content-between align-items-start">
                                        <a href="{{ route('baiviet.danhmuc', ['id' => $dm->id]) }}" class="text-decoration-none text-dark w-100 d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">{{ $dm->tendm }}</div>
                                            </div>
                                            <span class="badge text-bg-success rounded-pill flex-shrink-0">{{ $dm->baiviet_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

<style>
    .section-title-aside {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
    }

    .section-title-text h5 {
        position: relative;
        padding-left: 20px;
        line-height: 1.2;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    .section-title-text h5::before {
        position: absolute;
        content: "/";
        font-size: 1.5rem;
        font-weight: 800;
        color: #fe9705;
        left: 0;
        top: 0;
    }

    .custom-card {
        border: none;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-link {
        display: block;
    }

    .image-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        aspect-ratio: 4 / 3;
    }

    .card-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

     .custom-card:hover .card-image {
        transform: scale(1.1);
    }

    .content-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 1rem;
        color: white;
        z-index: 1;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 50%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
    }

    .content-overlay h6 {
        color: white !important;
        margin-bottom: 0.5rem;
        font-size: 1rem;
        line-height: 1.3;
    }

    .content-overlay p {
        font-size: 0.875rem;
    }

    .badge.bg-orange {
        background-color: orange !important;
    }

    .list-group-item a {
        color: inherit;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
     .list-group-item a:hover {
         color: var(--bs-primary);
     }

    @media (max-width: 767.98px) {
         .baiviet-search-form {
             flex-direction: column;
             align-items: stretch;
         }
         .baiviet-search-form input[type="text"] {
             width: 100% !important;
         }
          .baiviet-search-form button {
             width: 100%;
         }
    }

</style>