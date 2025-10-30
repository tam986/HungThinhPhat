@extends('Profile')
@section('title', 'Trang chủ')
@section('subtitle', 'Thông tin cá nhân')
@section('subsubtitle', 'Sản phẩm yêu thích')
@section('subtitle_url')
    {{ route('profile.profileUser') }}
@endsection
@section('styles')
    <style>
        .btn-favorite {
            transition: all 0.3s;
        }

        .btn-favorite.favorited {
            color: red !important;
        }

        .btn-favorite:hover {
            background-color: #f8f9fa;
        }

        .btn-remove-favorite {
            z-index: 10;
            opacity: 0.9;
            transition: all 0.2s ease;
        }

        .btn-remove-favorite:hover {
            opacity: 1;
            transform: scale(1.1);
        }
    </style>
@endsection
@section('profile_content')
    <div class="pt-3">
        <div class="container rounded shadow-sm p-2 d-flex align-items-center bg-white mb-4">
            <h4 class="title-profile">Sản phẩm yêu thích</h4>
        </div>
        <div class="row">
            @forelse ($favorites as $item)
                <div class=" col-md-3 mb-4">
                    <a href="{{ optional($item->bienthe?->sanpham)->id
                        ? route('sanpham.detail', ['id' => $item->bienthe->sanpham->id, 'id_bienthe' => $item->id_bienthe])
                        : route('sanpham.index') }}"
                        class="text-decoration-none">
                        <div class="card h-100 shadow-sm product-card" style="border-radius: 10px;">

                            <div class="position-relative overflow-hidden">
                                <button class="btn btn-sm btn-danger btn-remove-favorite position-absolute top-0 end-0 m-2"
                                    data-id="{{ $item->id_bienthe }}" data-url="{{ url()->current() }}"
                                    title="Xóa khỏi yêu thích">
                                    <i class="bi bi-trash fs-4"></i>
                                </button>
                                <img src="{{ $item->bienthe && $item->bienthe->hinh
                                    ? asset('storage/' . $item->bienthe->hinh)
                                    : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                    class="card-img-top product-image"
                                    alt="{{ optional($item->bienthe?->sanpham)->tensp ?? 'Sản phẩm không xác định' }}"
                                    style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="card-body text-center position-relative d-flex flex-column">
                                <div class="d-flex justify-content-center align-items-center" style="height: 60px;">
                                    <h6 class="card-text mb-0" style="height: 50px;">
                                        {{ optional($item->bienthe?->sanpham)->tensp ?? 'Sản phẩm không xác định' }}
                                    </h6>
                                </div>
                                <p class="card-text text-success mb-0 product-price mt-auto">
                                    {{ number_format($item->bienthe?->gia ?? 0) }} đ
                                </p>
                                <form method="POST" action="{{ route('cart.add') }}" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="id_bienthe" value="{{ $item->id_bienthe }}">
                                    <input type="hidden" name="soluong" value="1">
                                    <button type="submit" class="btn btn-primary w-100"
                                        style="background-color: #fe9705; border: none;">
                                        Mua ngay
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="container">
                    <div class="row justify-content-center align-items-center text-center mt-5">
                        <div class="col-md-6">
                            <h4 class="text-muted">Không có sản phẩm yêu thích nào.</h4>
                            <p class="text-muted">Hãy thêm sản phẩm vào danh sách yêu thích để theo dõi chúng.</p>
                            <a href="{{ route('sanpham.index') }}" class="btn btn-primary">Khám phá sản phẩm</a>
                        </div>
            @endforelse


        </div>
        {{-- 
        <div class="container mt-5">

            <div id="favorites-list" class="row">
                @if (Auth::check())
                    @forelse ($favorites as $favorite)
                        <div class="col-md-3 mb-4">
                            <div class="card favorite-card shadow-sm">
                                <div class="position-relative">
                                    <a
                                        href="{{ route('sanpham.detail', ['id' => $favorite->sanpham->id, 'id_bienthe' => $favorite->id_bienthe]) }}">
                                        <img src="{{ asset('storage/' . $favorite->bienthe->hinh) }}"
                                            class="card-img-top product-image" alt="{{ $favorite->sanpham->tensp }}">
                                    </a>
                                </div>
                                <div class="card-body text-center">
                                    <h6 class="card-title">
                                        <a href="{{ route('sanpham.detail', ['id' => $favorite->sanpham->id, 'id_bienthe' => $favorite->id_bienthe]) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $favorite->sanpham->tensp }}
                                        </a>
                                    </h6>
                                    <p class="text-muted">{{ $favorite->bienthe->nhanbanh->tenNhanBanh ?? 'N/A' }} -
                                        {{ $favorite->bienthe->khoiluong->khoiluong ?? 'N/A' }}g</p>
                                    <p class="text-danger">{{ number_format($favorite->bienthe->gia ?? 0) }} đ</p>
                                    <button class="btn btn-outline-danger btn-remove-favorite"
                                        data-id="{{ $favorite->id_bienthe }}">Xóa khỏi yêu thích</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Chưa có sản phẩm yêu thích nào.</p>
                    @endforelse
                @else
                    <!-- Placeholder for localStorage favorites, populated by JavaScript -->
                @endif
            </div>
        </div> --}}
    </div>
@endsection
@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-favorite').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id_bienthe = this.getAttribute('data-id');
                    const url = this.getAttribute('data-url');
                    const isFavorited = this.classList.contains('favorited');
                    const yeuthichAddUrl = '{{ route('yeuthich.add') }}';
                    const yeuthichRemoveUrl = '{{ route('yeuthich.remove') }}';
                    const endpoint = isFavorited ? yeuthichRemoveUrl : yeuthichAddUrl;

                    // Kiểm tra đăng nhập
                    @if (!Auth::check())
                        alert('Vui lòng đăng nhập để thêm/xóa yêu thích.');
                        window.location.href = '{{ route('login.form') }}';
                        return;
                    @endif

                    fetch(endpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id_bienthe,
                                url
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response
                                    .status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.classList.toggle('favorited', data.favorited);
                                this.querySelector('i').classList.toggle('bi-heart-fill', data
                                    .favorited);
                                this.querySelector('i').classList.toggle('bi-heart', !data
                                    .favorited);
                                if (!data.favorited) {
                                    this.closest('.col-6.col-md-3.mb-4')?.remove();
                                    if (!document.querySelector('.col-6.col-md-3.mb-4')) {
                                        window.location.reload();
                                    }
                                }
                                document.querySelector('#favorites-count').textContent =
                                    `(${data.favoritesCount})`;
                                alert(data.message || (data.favorited ?
                                    'Đã thêm vào yêu thích' : 'Đã xóa khỏi yêu thích'));
                            } else {
                                alert(data.message || 'Đã có lỗi xảy ra');
                            }
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error);
                            alert('Lỗi khi thêm/xóa yêu thích. Vui lòng thử lại.');
                        });
                });
            });
        });
        document.querySelectorAll('.btn-remove-favorite').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id_bienthe = this.getAttribute('data-id');
                const url = this.getAttribute('data-url');

                fetch(`{{ route('yeuthich.remove') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_bienthe,
                            url
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Đã xóa khỏi yêu thích');
                            this.closest('.col-md-3').remove();

                            // Reload nếu hết danh sách
                            if (!document.querySelector('.col-md-3')) {
                                window.location.reload();
                            }

                            document.querySelector('#favorites-count').textContent =
                                `(${data.favoritesCount || 0})`;
                        } else {
                            alert(data.message || 'Không thể xóa sản phẩm này');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Lỗi khi xóa khỏi yêu thích.');
                    });
            });
        });
    </script>
@endsection
