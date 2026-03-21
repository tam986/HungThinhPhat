@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Đơn hàng')
@section('content')
    <div class="container-fluid p-3">
        <div class="card shadow-lg border-0 bg-white text-dark mb-4 animate__animated animate__zoomIn">
            <form id="order-form" method="POST" action="{{ route('donhang.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-9">
                            <!-- Người đặt -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card card-full-height">
                                        <div class="card-header">
                                            <h5>Người đặt</h5>
                                        </div>
                                        <div class="card-body">
                                            <h5>Tâm</h5>
                                            {{-- <H5>{{ Auth::user()->hoten }}</H5>
                                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}"> --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- Thông tin khách nhận -->
                                <div class="col-md-8">
                                    <div class="card card-full-height">
                                        <div class="card-header">
                                            <h5>Thông tin khách nhận</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="tennguoinhan" class="form-label fw-semibold">Tên người
                                                        nhận</label>
                                                    <input type="text" name="tennguoinhan" id="tennguoinhan"
                                                        class="form-control shadow-sm" placeholder="Nhập tên người nhận"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="phone" class="form-label fw-semibold">Số điện
                                                        thoại</label>
                                                    <input type="text" name="phone" id="phone"
                                                        class="form-control shadow-sm" placeholder="Nhập số điện thoại"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="diachi" class="form-label fw-semibold">Địa chỉ giao
                                                        hàng</label>
                                                    <input type="text" name="diachi" id="diachi"
                                                        class="form-control shadow-sm" placeholder="Nhập địa chỉ giao hàng"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label fw-semibold">Email nhận
                                                        hàng</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control shadow-sm" placeholder="Nhập email người nhận"
                                                        required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="ghichu" class="form-label fw-semibold">Ghi chú</label>
                                                    <textarea name="ghichu" id="ghichu" class="form-control shadow-sm" placeholder="Nhập ghi chú (nếu có)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chi tiết đơn hàng -->
                            <div class="mb-4">
                                <h5 class="text-dark fw-semibold mb-3">Chi tiết đơn hàng</h5>
                                <div class="row bg-light border-0 shadow-sm rounded p-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h2>Giỏ Hàng sản phẩm</h2>
                                            <a href="{{ route('sanpham.index') }}" class="btn btn-dark"
                                                style="background-color: #fe9705; border: none;">
                                                Tiếp tục mua hàng
                                            </a>
                                        </div>

                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @forelse ($cart as $item)
                                            <div class="row mb-4 border-bottom pb-3 align-items-center">
                                                <div class="col-md-2">
                                                    <img src="{{ asset('storage/uploads/img-sp/' . ($item['hinh'] ?? 'default.jpg')) }}"
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
                                                    @if ($item['soluong'] == 1)
                                                        <p class="text-danger font-weight-bold">
                                                            {{ number_format($item['gia'], 0) }} đ</p>
                                                    @else
                                                        <p class="text-muted mb-1" style="text-decoration: line-through;">
                                                            {{ number_format($item['gia'], 0) }} đ
                                                        </p>
                                                        <p class="text-danger font-weight-bold">
                                                            {{ number_format($item['giakm'], 0) }} đ</p>
                                                    @endif
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="input-group" style="width: 120px;">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateSoluong('{{ $item['id_bienthe'] }}', -1)">-</button>
                                                        <input type="text" class="form-control text-center"
                                                            value="{{ $item['soluong'] }}" readonly>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateSoluong('{{ $item['id_bienthe'] }}', 1)">+</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <p class="text-danger font-weight-bold">
                                                        {{ number_format($item['subtotal'], 0) }} đ</p>
                                                </div>

                                                <div class="col-md-1 text-end">
                                                    <form action="{{ route('cart.destroy', $item['id_bienthe']) }}"
                                                        method="POST">
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
                            </div>

                        </div>

                        <!-- Thông tin thanh toán -->
                        <div class="col-md-3">
                            <div class="card shadow-sm mb-3">
                                <div class="card-header">
                                    <h5>Thông tin thanh toán</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Phương thức thanh toán</label>
                                        <input type="ratio" name="payment_type" value="pay-later" id="">
                                        <input type="ratio" name="payment_type" value="online_payment" id="">

                                    </div>
                                    <div class="mb-3">
                                        <label>Phương thức vận chuyển</label>
                                        <select name="vanchuyen" class="form-control">
                                            <option value="">Chọn phương thức vận chuyển</option>
                                            <option value="fast">Nhanh</option>
                                            <option value="superFast">Hỏa tốc</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Tạm tính</label>
                                        <span id="tam-tinh">0₫</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Tiền giảm</label>
                                        <span id="tien-giam" class="text-danger">0₫</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Tiền vận chuyển</label>
                                        <span id="tien-vc">0₫</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Thành tiền</label>
                                        <span id="thanh-tien">0₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end border-0">
                    <a href="{{ route('donhang.index') }}"
                        class="btn btn-outline-secondary shadow-sm btn-hover-gradient me-3">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm btn-hover-gradient">
                        <i class="bi bi-save"></i> Tạo đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

<style>
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .form-control,
    .form-select,
    .btn {
        border-radius: 10px;
    }

    .btn-hover-gradient {
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(45deg, #007bff, #00b4db);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #0056b3, #0098b8);
    }

    .btn-danger {
        background: linear-gradient(45deg, #ef5350, #d32f2f);
        border: none;
    }

    .btn-hover-gradient:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .product-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
    }

    .card-full-height {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .delete-product-item.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Voucher Card */
    .voucher-card-container {
        display: inline-block;
    }

    .voucher-card {
        margin: 10px;
    }

    .voucher-label {
        width: 180px;
        padding: 20px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ff8f9d 0%, #ffb6c1 100%);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.2s ease, background 0.3s ease;
    }

    .voucher-label:hover {
        transform: scale(1.05);
    }

    .voucher-title {
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        text-transform: uppercase;
    }

    .voucher-value {
        font-size: 16px;
        font-weight: bold;
        color: #fff;
    }

    .voucher-radio {
        top: 10px;
        right: 10px;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border-radius: 50%;
        transition: background-color 0.3s ease;
    }

    input[type="radio"]:checked+.voucher-label {
        background: linear-gradient(135deg, #ff6f81 0%, #ff99ac 100%);
    }

    input[type="radio"]:checked+.voucher-label .voucher-radio {
        background-color: #ff4d4d;
    }

    input[type="radio"]:disabled+.voucher-label {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
