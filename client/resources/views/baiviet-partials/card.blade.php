@isset($post)
    @if (isset($type) && $type === 'list')
        {{-- Kiểu list - Hiển thị cho danh sách bài viết liên quan trên mobile/tablet --}}
        <div class="d-flex flex-column flex-sm-row border rounded p-3 mb-3 gap-3 align-items-start bg-white shadow-sm">
            <a href="{{ route('baiviet.show', $post->slug) }}" class="flex-shrink-0" style="max-width: 150px;">
                <img src="{{ config('app.cms_url') . '/storage/' . $post->anhdaidien }}"
                    alt="{{ $post->tieude }}" style="width: 100%; height: auto; object-fit: cover;" class="rounded">
            </a>

            <div class="flex-grow-1 d-flex flex-column justify-content-between mt-2 mt-sm-0">
                <div>
                    <h5 class="mb-1">
                        <a href="{{ route('baiviet.show', $post->slug) }}" class="text-decoration-none text-dark">
                            {{ $post->tieude }}
                        </a>
                    </h5>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-calendar-event"></i> {{ $post->created_at->format('d/m/Y') }}
                        &nbsp;|&nbsp;
                        <i class="bi bi-eye"></i> {{ $post->luotxem }} lượt xem
                    </p>
                </div>
                <div class="mt-auto d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="badge bg-warning text-dark">{{ $post->danhmuc->tendm ?? 'Không rõ' }}</span>
                    <a href="{{ route('baiviet.show', $post->slug) }}" class="btn btn-outline-warning text-dark btn-sm">
                        Đọc tiếp
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Kiểu card - Dành cho desktop --}}
        <div class="card baiviet-card h-100 shadow-sm border-0">
            <a href="{{ route('baiviet.show', $post->slug) }}">
                <img src="{{ config('app.cms_url') . '/storage/' . $post->anhdaidien }}"
                    class="card-img-top" alt="{{ $post->tieude }}" style="object-fit: cover; height: 200px;">
            </a>
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <h5 class="card-title mb-2">
                        <a href="{{ route('baiviet.show', $post->slug) }}" class="text-decoration-none text-dark">
                            {{ $post->tieude }}
                        </a>
                    </h5>
                    <p class="card-text text-muted small mb-2">
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                        &nbsp;|&nbsp;
                        <i class="bi bi-eye"></i> {{ $post->luotxem }} lượt xem
                    </p>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2">
                    <span class="badge bg-warning text-dark">{{ $post->danhmuc->tendm ?? 'Không rõ' }}</span>
                    <a href="{{ route('baiviet.show', $post->slug) }}" class="btn btn-outline-warning btn-sm text-dark">
                        Đọc tiếp
                    </a>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="text-danger">⚠️ Thiếu biến $post trong card.blade.php</div>
@endisset
<style>
    .baiviet-card img {
        width: 100%;
        object-fit: cover;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    /* Responsive cho mobile */
    @media (max-width: 575.98px) {
        .baiviet-card .card-body {
            padding: 1rem;
        }

        .baiviet-card h5 {
            font-size: 1rem;
        }

        .baiviet-card .btn {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
