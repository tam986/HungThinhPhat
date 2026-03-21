@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Bài viết')
@section('subtitle_url')
    {{ route('baiviet.index') }}
@endsection
@section('subsubtitle', $danhmucChon->tendm ?? 'Tất cả bài viết')

@section('content')
    <div class="container my-4">

        <form action="{{ route('baiviet.search') }}" method="GET" class="mb-4 d-flex gap-2 flex-column flex-md-row align-items-stretch">
            <input type="hidden" name="danhmuc" value="{{ $danhmucChon->id ?? '' }}">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm bài viết..."
                class="form-control flex-grow-1">
            <button type="submit" class="btn text-white flex-shrink-0" style="background-color: orange; border: none;">
                Tìm
            </button>
        </form>

        <div class="row g-4">

            <div class="col-md-9">

                @if (($baiVietChinh ?? null) || ($baiVietPhu->count() ?? 0) > 0 || ($baiViet->count() ?? 0) > 0)

                    <div class="featured-articles mb-5 bg-white shadow-sm rounded p-3">
                        <h4 class="fw-bold mb-3">
                             @if ($danhmucChon)
                                 Bài viết thuộc danh mục: {{ $danhmucChon->tendm }}
                             @else
                                 Danh sách bài viết
                             @endif
                         </h4>

                        @if ($baiVietChinh ?? null)
                            <div class="main-featured-article row g-3 mb-4">
                                <div class="col-md-6">
                                    @if ($baiVietChinh->anhdaidien)
                                        <a href="{{ route('baiviet.show', $baiVietChinh->slug) }}" class="d-block h-100">
                                            <img src="{{ config('app.cms_url') . '/storage/' . $baiVietChinh->anhdaidien }}"
                                                class="img-fluid rounded main-featured-img" alt="{{ $baiVietChinh->tieude }}">
                                        </a>
                                    @else
                                        <a href="{{ route('baiviet.show', $baiVietChinh->slug) }}" class="d-block h-100">
                                            <img src="{{ asset('images/placeholder.jpg') }}" {{-- Thay bằng đường dẫn ảnh mặc định của client --}}
                                                 class="img-fluid rounded main-featured-img" alt="{{ $baiVietChinh->tieude }}">
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-6 d-flex flex-column justify-content-center p-3">
                                    <a href="{{ route('baiviet.show', $baiVietChinh->slug) }}"
                                        class="text-decoration-none text-dark">
                                        <h3 class="fw-bold mb-2">{{ $baiVietChinh->tieude }}</h3>
                                    </a>
                                    <p class="text-muted small mb-2">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($baiVietChinh->noidung), 200) }}</p>
                                    <p class="text-muted small mb-0">{{ $baiVietChinh->created_at->format('d/m/Y') }} -
                                        {{ $baiVietChinh->luotxem }} lượt xem</p>
                                </div>
                            </div>
                        @endif

                       @if (($baiVietPhu->count() ?? 0) > 0)
                            <h5 class="fw-bold mb-3">Các bài nổi bật khác</h5>
                            <div class="small-featured-list row g-3">
                                @foreach ($baiVietPhu as $smallPost)
                                     <div class="col-12 col-sm-4 col-md-4">
                                         <a href="{{ route('baiviet.show', $smallPost->slug) }}" class="small-featured-card text-decoration-none text-dark d-block">
                                             @if ($smallPost->anhdaidien)
                                                 <img src="{{ config('app.cms_url') . '/storage/' . $smallPost->anhdaidien }}"
                                                     class="img-fluid rounded mb-2 small-featured-img" alt="{{ $smallPost->tieude }}">
                                             @else
                                                 <img src="{{ asset('images/placeholder.jpg') }}" {{-- Thay bằng đường dẫn ảnh mặc định của client --}}
                                                      class="img-fluid rounded mb-2 small-featured-img" alt="{{ $smallPost->tieude }}">
                                             @endif
                                             <h6 class="fw-bold mb-1">{{ \Illuminate\Support\Str::limit($smallPost->tieude, 50) }}</h6>
                                             <p class="text-muted small mb-0">{{ $smallPost->created_at->format('d/m/Y') }}</p>
                                         </a>
                                     </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <div class="regular-articles-list bg-white shadow-sm rounded p-3 mb-5">
                        <h5 class="fw-bold mb-3">Các bài viết khác</h5>
                        <div class="row g-3">
                            @forelse($baiViet as $post)
                                <div class="col-12">
                                    @include('baiviet-partials.card', ['post' => $post, 'type' => 'list'])
                                </div>
                            @empty
                                @if (!($baiVietChinh ?? null) && ($baiVietPhu->count() ?? 0) === 0)
                                    <div class="col-12">
                                        <p>Không có bài viết nào trong danh mục này.</p>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <p>Đã hết bài viết trong danh mục này.</p>
                                    </div>
                                @endif
                            @endforelse
                        </div>

                        @if (($baiViet->total() ?? 0) > ($baiViet->perPage() ?? 15))
                            <div class="d-flex justify-content-center mt-4">
                                {{ $baiViet->links() }}
                            </div>
                        @endif

                    </div>
                @else
                    <div class="bg-white shadow-sm rounded p-3 mb-5 text-center">
                         <p class="mb-0">Không có bài viết nào trong danh mục này.</p>
                    </div>
                @endif

            </div>

                 @include('pages.SidebarBaiviet', [
                     'danhmuc' => $danhmuc,
                     'danhmucChon' => $danhmucChon ?? null,
                 ])

        </div>
    </div>
@endsection

<style>
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

    .main-featured-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .small-featured-img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

     .small-featured-card:hover .small-featured-img {
         transform: scale(1.05);
     }
</style>