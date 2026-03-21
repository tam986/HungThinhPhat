@extends('layouts.layout')
@section('title', 'Giỏ Hàng')
@section('subtitle', 'Cửa hàng')
@section('subsubtitle', 'Giỏ Hàng')
@section('content')
    <div class="row bg-light border-0 shadow-sm rounded p-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Giỏ Hàng ({{ $totalItems }} sản phẩm)</h2>
                <a href="{{ route('sanpham.index') }}" class="btn btn-dark" style="background-color: #fe9705; border: none;">
                    Tiếp tục mua hàng
                </a>
            </div>

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

            @forelse ($cart as $item)
                <div class="row mb-4 border-bottom pb-3 align-items-center">
                    <div class="col-md-2">
                        <img src="{{ config('app.cms_url') . '/storage/' . ($item['hinh'] ?? 'default.jpg') }}"
                            class="img-fluid rounded shadow-sm" alt="{{ $item['tensp'] }}"
                            style="height: 100px; object-fit: cover; width: 100%;">
                    </div>

                    <div class="col-md-5">
                        <h5>{{ $item['tensp'] }}</h5>
                        <p class="text-muted mb-1">
                            (Kho: còn {{ $item['soluong_tonkho'] ?? '0' }} sản phẩm)
                        </p>
                        <p class="text-muted mb-1">
                            <b>Nhân bánh - Khối lượng:</b>
                            {{ $item['tenNhanBanh'] ?? 'Không có' }}-{{ $item['khoiluong'] ?? 'Không có' }}g
                        </p>
                        @if (isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'])
                            <p class="text-muted mb-1" style="text-decoration: line-through;">
                                Giá gốc: {{ number_format($item['gia'], 0) }} đ
                            </p>
                            <p class="text-danger font-weight-bold">
                                Giá KM: {{ number_format($item['giakm'], 0) }} đ
                            </p>
                        @else
                            <p class="text-success font-weight-bold">
                                Giá gốc: {{ number_format($item['gia'], 0) }} đ
                            </p>
                        @endif
                    </div>

                    <div class="col-md-2">
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="updateSoluong('{{ $item['id_bienthe'] }}', -1)">-</button>
                            <input type="text" class="form-control text-center" value="{{ $item['soluong'] }}" readonly>
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="updateSoluong('{{ $item['id_bienthe'] }}', 1)">+</button>
                        </div>
                    </div>

                    <div class="col-md-2">
                        @if (isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'])
                            <p class="text-danger font-weight-bold">
                                {{ number_format($item['soluong'] * $item['giakm'], 0) }} đ</p>
                        @else
                            <p class="text-danger font-weight-bold">{{ number_format($item['subtotal'], 0) }} đ</p>
                        @endif
                    </div>

                    <div class="col-md-1 text-end">
                        <form action="{{ route('cart.destroy', $item['id_bienthe']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Giỏ hàng của bạn đang trống.</p>
                    <a href="{{ route('sanpham.index') }}" class="btn btn-primary"
                        style="background-color: #fe9705; border: none;">
                        Quay lại mua sắm
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    @if (!empty($cart))
        <div class="row mt-5 bg-light border-0 shadow-sm rounded p-4">
            <div class="col-12">
                <h3>Tóm Tắt Đơn Hàng</h3>

                <div class="row mb-3">
                    <p><b>Sản phẩm ({{ $totalItems }})</b></p>
                    <div class="col-md-6">
                        @foreach ($cart as $item)
                            <p>{{ $item['tensp'] }} x {{ $item['soluong'] }}</p>
                        @endforeach
                    </div>
                    <div class="col-md-6 text-end">
                        @foreach ($cart as $item)
                            @if (isset($item['giakm']) && $item['giakm'] > 0 && $item['giakm'] < $item['gia'])
                                <p>{{ number_format($item['soluong'] * $item['giakm'], 0) }} đ</p>
                            @else
                                <p>{{ number_format($item['subtotal'], 0) }} đ</p>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><b>Số tiền vận chuyển</b></p>
                    </div>
                    <div class="col-md-6 text-danger text-end">
                        <p id="shipping-amount">+ {{ number_format($shipping, 0) }} đ</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><b>Số tiền đã giảm</b></p>
                    </div>
                    <div class="col-md-6 text-end text-success">
                        @php
                            $coupon = Session::get('coupon');
                            $discount = 0;
                            if ($coupon && isset($coupon['hesogiamgia'])) {
                                $discount = $totalPrice * ($coupon['hesogiamgia'] / 100);
                            }
                        @endphp
                        <p id="discount-amount">- {{ number_format($discount, 0) }} đ</p>
                    </div>
                </div>

                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-md-6">
                        <p><b>Shipping</b></p>
                    </div>
                    <div class="col-md-4">
                        <form method="POST" action="{{ route('cart.applyShipping') }}">
                            @csrf
                            <div class="input-group">
                                <select name="shipping" class="form-control">
                                    <option value="8000"
                                        {{ Session::get('shipping_fee', 8000) == 8000 ? 'selected' : '' }}>Thông thường
                                        (8,000 đ)</option>
                                    <option value="15000"
                                        {{ Session::get('shipping_fee', 8000) == 15000 ? 'selected' : '' }}>Nhanh (15,000
                                        đ)</option>
                                    <option value="20000"
                                        {{ Session::get('shipping_fee', 8000) == 20000 ? 'selected' : '' }}>Hỏa tốc (20,000
                                        đ)</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-hover-gradient"
                                    style="background-color: #fe9705; border: none;">
                                    Áp dụng
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-md-6">
                        <p><b>Discount</b></p>
                    </div>
                    <div class="col-md-4">
                        @if (Session::has('coupon'))
                            <form method="POST" action="{{ route('cart.removeCoupon') }}">
                                @csrf
                                <div class="input-group">
                                    <select name="magiamgia" class="form-control" disabled>
                                        <option value="">Chọn mã giảm giá</option>
                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->magiamgia }}"
                                                {{ Session::get('coupon.magiamgia') == $coupon->magiamgia ? 'selected' : '' }}>
                                                {{ $coupon->magiamgia }} (Giảm {{ $coupon->hesogiamgia }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-danger btn-hover-gradient">
                                        Hủy bỏ
                                    </button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('cart.applyCoupon') }}">
                                @csrf
                                <div class="input-group">
                                    <select name="magiamgia" class="form-control">
                                        <option value="">Chọn mã giảm giá</option>
                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->magiamgia }}"
                                                {{ Session::get('coupon.magiamgia') == $coupon->magiamgia ? 'selected' : '' }}>
                                                {{ $coupon->magiamgia }} (Giảm {{ $coupon->hesogiamgia }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-hover-gradient"
                                        style="background-color: #fe9705; border: none;">
                                        Áp dụng
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="row border-top pt-3">
                    <div class="col-md-6">
                        <h5><b>Tổng Tiền Thanh Toán</b></h5>
                    </div>
                    <div class="col-md-6 text-end">
                        @php
                            $finalPrice = $totalPrice - $discount + $shipping;
                        @endphp
                        <h5 class="text-danger" id="final-price">{{ number_format($finalPrice, 0) }} đ</h5>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary w-100 btn-hover-gradient checkout-btn"
                            style="background-color: #fe9705; border: none;">
                            Thanh Toán
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Yêu cầu đăng nhập</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Vui lòng đăng nhập để tiếp tục thanh toán.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-hover-gradient"
                            style="background-color: #fe9705; border: none;">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        function updateSoluong(id, change) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('cart.update', '__id__') }}'.replace('__id__', id);

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);

            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id_bienthe';
            idInput.value = id;
            form.appendChild(idInput);

            const changeInput = document.createElement('input');
            changeInput.type = 'hidden';
            changeInput.name = 'capnhat';
            changeInput.value = change;
            form.appendChild(changeInput);

            document.body.appendChild(form);
            form.submit();
        }

        document.querySelector('.checkout-btn').addEventListener('click', function() {
            const isAuthenticated = @json(Auth::check());
            if (isAuthenticated) {
                window.location.href = '{{ route('donhang.index') }}';
            } else {
                $('#loginModal').modal('show');
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        .form-control:focus {
            border-color: #fe9705;
            box-shadow: 0 0 5px rgba(254, 151, 5, 0.3);
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .text-danger {
            font-weight: bold;
        }

        /* Hiệu ứng cho nút */
        .btn-hover-gradient {
            transition: all 0.3s ease;
        }

        .btn-primary.btn-hover-gradient:hover {
            background: linear-gradient(45deg, #e08500, #fe9705);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-danger.btn-hover-gradient:hover {
            background: linear-gradient(45deg, #c82333, #dc3545);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Hiệu ứng fade cho số tiền */
        #shipping-amount,
        #discount-amount,
        #final-price {
            transition: opacity 0.3s ease;
        }

        #shipping-amount.fade,
        #discount-amount.fade,
        #final-price.fade {
            opacity: 0;
        }

        /* Modal */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0);
        }
    </style>
@endsection
