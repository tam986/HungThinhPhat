<div class="col-md-3 order-md-last baiviet-sidebar">
    <div class="bg-white shadow-sm rounded p-3 mb-4">
        <h5 class="fw-bold mb-3">Danh mục bài viết</h5>
        <ul class="list-unstyled baiviet-danhmuc-list">
            @foreach ($danhmuc as $dm)
                <li class="mb-2">
                    <a href="{{ route('baiviet.danhmuc', $dm->id) }}"
                        class="btn btn-link p-0 text-start text-decoration-none {{ isset($danhmucChon) && $danhmucChon->id == $dm->id ? 'fw-bold text-primary' : '' }}">
                        {{ $dm->tendm }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white shadow-sm rounded p-3 mb-4 baiviet-xemnhanh">
        <h5 class="fw-bold">Bài viết xem nhanh</h5>
        @foreach (\App\Models\Baiviet::orderBy('created_at', 'desc')->limit(3)->get() as $bv)
            <div class="mb-2">
                <a href="{{ route('baiviet.show', $bv->slug) }}">
                    <strong>{{ $bv->tieude }}</strong>
                </a>
                <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($bv->noidung), 60) }}</p>
            </div>
        @endforeach
    </div>
</div>
