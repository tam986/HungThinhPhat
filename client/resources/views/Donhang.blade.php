@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Đơn hàng')
@section('content')
    <div class="container-fluid p-3">
        <div class="card shadow-lg border-0 bg-white text-dark mb-4 animate__animated animate__fadeIn">
            <form id="order-form" method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card card-full-height modern-card">
                                        <div class="card-header modern-header">
                                            <h5>Người đặt</h5>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <div class="form-check">
                                                    <label class="d-flex gap-2 align-items-center modern-label">
                                                        <input type="radio" name="select-user" id="auth-user"
                                                            value="auth" class="form-check-input" checked>
                                                        {{ Auth::user()->hoten }}
                                                    </label>
                                                </div>
                                                <div class="form-check mt-2">
                                                    <label class="d-flex gap-2 align-items-center modern-label">
                                                        <input type="radio" name="select-user" id="new-address"
                                                            value="new" class="form-check-input">
                                                        Chọn địa chỉ mới
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="user-info-preview"
                                                class="mt-3 p-3 border rounded bg-light d-none modern-info">
                                                <p><strong>Họ tên:</strong> <span
                                                        id="info-hoten">{{ Auth::user()->hoten }}</span></p>
                                                <p><strong>Email:</strong> <span
                                                        id="info-email">{{ Auth::user()->email }}</span></p>
                                                <p><strong>Số điện thoại:</strong> <span
                                                        id="info-phone">{{ Auth::user()->sodienthoai }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card card-full-height modern-card">
                                        <div class="card-header modern-header">
                                            <h5>Thông tin khách nhận</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3" id="customer-info">
                                                <div class="col-md-6">
                                                    <label for="tennguoinhan"
                                                        class="form-label fw-semibold modern-label">Tên người nhận</label>
                                                    <input type="text" name="tennguoinhan" id="tennguoinhan"
                                                        class="form-control modern-input" placeholder="Nhập tên người nhận"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="phone" class="form-label fw-semibold modern-label">Số
                                                        điện thoại</label>
                                                    <input type="text" name="phone" id="phone"
                                                        class="form-control modern-input" placeholder="Nhập số điện thoại"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="diachi" class="form-label fw-semibold modern-label">Địa
                                                        chỉ giao hàng</label>
                                                    <input type="text" name="diachi" id="diachi"
                                                        class="form-control modern-input"
                                                        placeholder="Nhập địa chỉ giao hàng" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label fw-semibold modern-label">Email
                                                        nhận hàng</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control modern-input"
                                                        placeholder="Nhập email người nhận" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="ghichu" class="form-label fw-semibold modern-label">Ghi
                                                        chú</label>
                                                    <textarea name="ghichu" id="ghichu" class="form-control modern-input" placeholder="Nhập ghi chú (nếu có)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-dark fw-semibold mb-3 modern-title">Chi tiết đơn hàng</h5>
                                <div class="row bg-light border-0 shadow-sm rounded p-4 modern-section">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h2 class="modern-subtitle">Thông tin giỏ hàng</h2>
                                        </div>

                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show modern-alert"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show modern-alert"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @forelse ($cart as $item)
                                            <div
                                                class="row mb-4 d-flex justify-content-between border-bottom pb-3 align-items-center modern-item">
                                                <div class="col-md-10">
                                                    <h5 class="modern-product-name">{{ $item['tensp'] }}
                                                        <span class="text-muted">x {{ $item['soluong'] }}</span>
                                                    </h5>
                                                    <p class="text-success modern-product-info">Nhân bánh:
                                                        {{ $item['tenNhanBanh'] ?? 'Không có' }} - Khối lượng:
                                                        {{ $item['khoiluong'] ?? 'Không có' }}g</p>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    @php
                                                        $gia =
                                                            isset($item['giakm']) &&
                                                            $item['giakm'] > 0 &&
                                                            $item['giakm'] < $item['gia']
                                                                ? $item['giakm']
                                                                : $item['gia'];
                                                        $thanhTienItem = $gia * $item['soluong'];
                                                    @endphp
                                                    <p class="text-danger font-weight-bold modern-price">
                                                        {{ number_format($thanhTienItem, 0) }} đ</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center">
                                                <p class="text-muted modern-empty">Giỏ hàng của bạn đang trống.</p>
                                                <a href="{{ route('sanpham.index') }}" class="btn btn-primary modern-btn"
                                                    style="background-color: #fe9705; border: none;">
                                                    Quay lại mua sắm
                                                </a>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm mb-3 modern-card">
                                <div class="card-header modern-header">
                                    <h5>Thông tin thanh toán</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="modern-label">Phương thức thanh toán</label><br>
                                        <div class="form-check">
                                            <label for="pay-later" class="d-flex align-items-center modern-label">
                                                <input type="radio" name="payment_type" value="pay_later"
                                                    id="pay-later" class="form-check-input" checked> COD
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <label for="online-payment" class="d-flex align-items-center modern-label">
                                                <input type="radio" name="payment_type" value="online_payment"
                                                    id="online-payment" class="form-check-input"> Online Banking
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="modern-label">Phương thức vận chuyển đã chọn</label>
                                        <select name="vanchuyen" class="form-control modern-input" disabled>
                                            <option value="normal"
                                                {{ session('shipping_fee', 8000) == 8000 ? 'selected' : '' }}>Thông thường
                                            </option>
                                            <option value="fast"
                                                {{ session('shipping_fee', 8000) == 15000 ? 'selected' : '' }}>Nhanh
                                            </option>
                                            <option value="superFast"
                                                {{ session('shipping_fee', 8000) == 20000 ? 'selected' : '' }}>Hỏa tốc
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="modern-label">Phiếu giảm giá</label>
                                        @if ($appliedCoupon)
                                            <select name="magiamgia" class="form-control modern-input" disabled>
                                                <option value="{{ $appliedCoupon->magiamgia }}">
                                                    {{ $appliedCoupon->magiamgia }} (Giảm
                                                    {{ $appliedCoupon->hesogiamgia }}%)</option>
                                            </select>
                                            <p class="text-success mt-2 modern-info">Mã giảm giá đã được áp dụng.</p>
                                        @else
                                            <select name="magiamgia" class="form-control modern-input" disabled>
                                                <option value="">{{ $couponMessage }}</option>
                                            </select>
                                            <p class="text-muted mt-2 modern-info">
                                                Đơn hàng từ {{ number_format(100000, 0) }} đ: giảm 10%<br>
                                                Từ {{ number_format(200000, 0) }} đ: giảm 15%<br>
                                                Từ {{ number_format(300000, 0) }} đ: giảm 20%<br>
                                                Từ {{ number_format(400000, 0) }} đ: giảm 25%<br>
                                                Từ {{ number_format(500000, 0) }} đ: giảm 30%
                                            </p>
                                        @endif
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label class="modern-label">Tạm tính</label>
                                        <span id="tam-tinh" class="modern-price">{{ number_format($tongTien, 0) }}
                                            đ</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label class="modern-label">Tiền giảm</label>
                                        <span id="tien-giam"
                                            class="text-success modern-price">{{ number_format($tienGiam, 0) }} đ</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label class="modern-label">Tiền vận chuyển</label>
                                        <span id="tien-vc"
                                            class="text-danger modern-price">{{ number_format($tienVC, 0) }} đ</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label class="modern-label">Thành tiền</label>
                                        <span id="thanh-tien"
                                            class="text-primary modern-price font-weight-bold">{{ number_format($thanhTien, 0) }}
                                            đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end border-0">
                    <a href="{{ route('cart.index') }}"
                        class="btn btn-outline-secondary shadow-sm btn-hover-gradient me-3 modern-btn">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm btn-hover-gradient modern-btn">
                        <i class="bi bi-save"></i> Tạo đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const hoten = "{{ Auth::user()->hoten ?? '' }}";
            const email = "{{ Auth::user()->email ?? '' }}";
            const phone = "{{ Auth::user()->sodienthoai ?? '' }}";

            function updateCustomerInfo(isAuthUser) {
                if (isAuthUser) {
                    $('#tennguoinhan').val(hoten);
                    $('#email').val(email);
                    $('#phone').val(phone);
                    $('#diachi').val('');
                    $('#ghichu').val('');
                    $('#user-info-preview').removeClass('d-none');
                } else {
                    $('#tennguoinhan').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#diachi').val('');
                    $('#ghichu').val('');
                    $('#user-info-preview').addClass('d-none');
                }
            }

            $('input[name="select-user"]').change(function() {
                const isAuthUser = $(this).val() === 'auth';
                updateCustomerInfo(isAuthUser);
            });

            updateCustomerInfo(true);

            // Xử lý sự kiện submit form
            $('#order-form').on('submit', function(e) {
                e.preventDefault(); // Ngăn form submit ngay lập tức

                // Kiểm tra xem đã chọn phương thức thanh toán chưa
                const paymentType = $('input[name="payment_type"]:checked').val();
                if (!paymentType) {
                    alert('Vui lòng chọn phương thức thanh toán.');
                    return;
                }

                // Xác nhận trước khi tạo đơn hàng
                const confirmMessage = paymentType === 'pay_later' ?
                    'Bạn có chắc chắn muốn tạo đơn hàng với phương thức thanh toán COD?' :
                    'Bạn sẽ được chuyển hướng đến cổng thanh toán VNPay. Bạn có chắc chắn muốn tiếp tục?';

                if (confirm(confirmMessage)) {
                    this.submit();
                }
            });
        });
    </script>
@endsection

<style>
    .modern-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .modern-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0;
        padding: 15px 20px;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .modern-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .modern-subtitle {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .modern-label {
        font-size: 0.95rem;
        font-weight: 500;
        color: #555;
        transition: color 0.2s ease;
    }

    .modern-label:hover {
        color: #fe9705;
    }

    .modern-input {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .modern-input:focus {
        border-color: #fe9705;
        box-shadow: 0 0 8px rgba(254, 151, 5, 0.2);
        outline: none;
    }

    .modern-section {
        border-radius: 12px;
        background: #f9fafb;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .modern-item {
        transition: background 0.3s ease;
        padding: 10px 0;
    }

    .modern-item:hover {
        background: #f1f3f5;
        border-radius: 8px;
    }

    .modern-product-name {
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
    }

    .modern-product-info {
        font-size: 0.9rem;
        color: #28a745;
    }

    .modern-price {
        font-size: 1rem;
        font-weight: 600;
    }

    .modern-empty {
        font-size: 1.1rem;
        color: #6c757d;
    }

    .modern-info {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .modern-btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary.modern-btn {
        background: linear-gradient(45deg, #fe9705, #ffaa33);
        border: none;
    }

    .btn-primary.modern-btn:hover {
        background: linear-gradient(45deg, #e08500, #fe9705);
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-outline-secondary.modern-btn {
        border-color: #e0e0e0;
        color: #555;
    }

    .btn-outline-secondary.modern-btn:hover {
        background: #f8f9fa;
        border-color: #fe9705;
        color: #fe9705;
    }

    .modern-alert {
        border-radius: 8px;
        padding: 15px;
        font-size: 0.95rem;
    }

    .animate__animated.animate__fadeIn {
        animation-duration: 0.8s;
    }
</style>
