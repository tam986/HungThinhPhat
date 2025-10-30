@extends('page.layout')
@section('title', 'Tạo đơn hàng')
@section('content')
    <div class="container-fluid p-3">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-4 animate__animated animate__fadeInDown">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-cart-plus text-danger bg-light p-4 fs-4"></i>
                <h4 class="text-dark mb-0 fw-bold">Đơn hàng chi tiết</h4>
            </div>
        </div>

        <!-- Thông báo -->
        <div id="alert-message"
            class="d-none alert alert-dismissible fade show shadow-sm rounded animate__animated animate__bounceIn"
            role="alert">
            <span id="alert-text"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card shadow-lg border-0 bg-white text-dark mb-4 animate__animated animate__zoomIn">


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


                                        <span><strong>Họ tên:</strong> <span
                                                id="info-hoten">{{ $donhang->user->hoten }}</span>
                                            </p>
                                            <p><strong>Email:</strong> <span
                                                    id="info-email">{{ $donhang->user->email }}</span>
                                            </p>
                                            <p><strong>Số điện thoại:</strong> <span
                                                    id="info-phone">{{ $donhang->user->sodienthoai }}</span></p>

                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin khách nhận -->
                            <div class="col-md-8">
                                <form id="order-form" method="POST" action="{{ route('donhang.update', $donhang->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
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
                                                        class="form-control shadow-sm"
                                                        placeholder="{{ $donhang->tennguoinhan }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="phone" class="form-label fw-semibold">Số điện
                                                        thoại</label>
                                                    <input type="text" name="phone" id="phone"
                                                        class="form-control shadow-sm" placeholder="{{ $donhang->phone }}"
                                                        disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="diachi" class="form-label fw-semibold">Địa chỉ giao
                                                        hàng</label>
                                                    <input type="text" name="diachi" id="diachi"
                                                        class="form-control shadow-sm" placeholder="{{ $donhang->diachi }}"
                                                        disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label fw-semibold">Email nhận
                                                        hàng</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control shadow-sm" placeholder="{{ $donhang->email }}"
                                                        disabled>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="ghichu" class="form-label fw-semibold">Ghi chú</label>
                                                    <input type="text" name="ghichu" id="ghichu"
                                                        class="form-control shadow-sm" placeholder="{{ $donhang->ghichu }}"
                                                        disabled></input>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer d-flex justify-content-end border-0">
                                            <button type="submit" class="btn btn-success">Cập nhật</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Chi tiết đơn hàng -->
                    <div class="mb-4 rounded">
                        <h5 class="text-dark fw-semibold mb-3">Chi tiết đơn hàng</h5>
                        <div class="rounded overflow-hidden shadow">
                            @foreach ($donhang->donhangchitiet as $chitiet)
                                <table class="table table-bordered table-striped align-middle text-center mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Mã đơn</th>
                                            <th scope="col">Sản phẩm</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#MD{{ $chitiet->id }}</td>
                                            <td class="text-start">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $chitiet->bienthe->hinh) }}"
                                                        alt="Ảnh sản phẩm" class="me-3 rounded"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                    <div>
                                                        <div>
                                                            <strong>{{ $chitiet->bienthe->sanpham->tensp }}</strong>
                                                        </div>
                                                        <div>{{ $chitiet->soluong }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$chitiet->gia}}</td>
                                            <td>{{$donhang->thanhtien}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            @endforeach

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
                            {{-- pt thanh toán --}}
                            <div class="mb-3 d-flex  flex-column  align-items-center">
                                <div>

                                    <h6 style="text-transform:uppercase">
                                        {{ $donhang->thanhToan->phuongthucthanhtoan }}</h6>
                                </div>
                                <form id="order-form" method="POST"
                                    action="{{ route('donhang.updateTT', ['id' => $donhang->thanhToan->id]) }}"
                                    enctype="multipart/form-data" onchange="this.submit()">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <select name="trangthai" id="trangthai" class="form-select ">
                                            <option value="chưa thanh toán"
                                                {{ $donhang->thanhToan->trangthai == 'chưa thanh toán' ? 'selected' : '' }}>
                                                Chưa thanh toán
                                            </option>
                                            <option value="đã thanh toán"
                                                {{ $donhang->thanhToan->trangthai == 'đã thanh toán' ? 'selected' : '' }}>
                                                Đã thanh toán
                                            </option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">

                            <div class="mb-3 d-flex justify-content-between">
                                <label>Tạm tính</label>
                                <span>{{ number_format($donhang->tongtien, 0, ',', '.') }}</h5>

                            </div>

                            <div class="mb-3 d-flex justify-content-between">
                                <label>Tiền giảm</label>
                                <span class="text-success">{{ number_format($donhang->sotiengiam, 0, ',', '.') }}
                                    </h5>

                            </div>

                            <div class="mb-3 d-flex justify-content-between">
                                <label>Tiền vận chuyển</label>
                                <span>{{ number_format($donhang->tienvc, 0, ',', '.') }}</h5>

                            </div>

                            <div class="mb-3 d-flex justify-content-between">
                                <label>Thành tiền</label>
                                <span>{{ number_format($donhang->thanhtien, 0, ',', '.') }}</h5>

                            </div>
                        </div>
                    </div>

                    <!-- Trạng thái đơn hàng -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <label for="trangthai" class="form-label fw-semibold">Trạng thái đơn hàng</label>
                            <form action="{{ route('donhang.updateStatus', $donhang->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @if ($errors->has('trangthai'))
                                    <div class="alert alert-danger">{{ $errors->first('trangthai') }}</div>
                                @endif
                                <select name="trangthai" class="form-control text-center" onchange="this.form.submit()">
                                    <option value="chờ xác nhận"
                                        {{ $donhang->trangthai == 'chờ xác nhận' ? 'selected' : '' }}>Chờ xác
                                        nhận</option>
                                    <option value="đã xác nhận"
                                        {{ $donhang->trangthai == 'đã xác nhận' ? 'selected' : '' }}>Đã xác nhận
                                    </option>
                                    <option value="đang giao" {{ $donhang->trangthai == 'đang giao' ? 'selected' : '' }}>
                                        Đang giao
                                    </option>
                                    <option value="hoàn thành"
                                        {{ $donhang->trangthai == 'hoàn thành' ? 'selected' : '' }}>
                                        Hoàn thành
                                    </option>
                                    <option value="hủy" {{ $donhang->trangthai == 'hủy' ? 'selected' : '' }}>
                                        Hủy</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end border-0">
            <a href="{{ route('donhang.index') }}" class="btn btn-outline-secondary shadow-sm btn-hover-gradient me-3">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <button type="submit" class="btn btn-primary shadow-sm btn-hover-gradient">
                <i class="bi bi-save"></i> Tạo đơn hàng
            </button>
        </div>

    </div>
    </div>
@endsection

@section('styles')
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
@endsection
