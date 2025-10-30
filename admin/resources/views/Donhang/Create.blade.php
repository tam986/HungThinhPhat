@extends('page.layout')
@section('title', 'Tạo đơn hàng')
@section('content')
    <div class="container-fluid p-3">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-4 animate__animated animate__fadeInDown">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-cart-plus text-danger bg-light p-4 fs-4"></i>
                <h4 class="text-dark mb-0 fw-bold">Tạo đơn hàng mới</h4>
            </div>
        </div>


        <div class="card shadow-lg border-0 bg-white text-dark mb-4 animate__animated animate__zoomIn">
            <form id="order-form" method="POST" action="{{ route('donhang.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card card-full-height">
                                <div class="card-header">
                                    <h5>Người đặt</h5>
                                </div>
                                <div class="card-body">
                                    <label for="id_user" class="form-label fw-semibold">Khách hàng</label>
                                    <select name="id_user" id="id_user" class="form-select shadow-sm" required>
                                        <option value="">Chọn khách hàng</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" data-id_user="{{ $user->id }}"
                                                data-hoten="{{ $user->hoten }}" data-email="{{ $user->email }}"
                                                data-phone="{{ $user->sodienthoai }}">
                                                {{ $user->hoten }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="user-info" class="mt-3 p-3 border rounded bg-light d-none">
                                        <p><strong>Họ tên:</strong> <span id="info-hoten"></span></p>
                                        <p><strong>Email:</strong> <span id="info-email"></span></p>
                                        <p><strong>Số điện thoại:</strong> <span id="info-phone"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Thông tin khách nhận -->
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
                                                class="form-control shadow-sm" placeholder="Nhập tên người nhận" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label fw-semibold">Số điện
                                                thoại</label>
                                            <input type="text" name="phone" id="phone"
                                                class="form-control shadow-sm" placeholder="Nhập số điện thoại" required>
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
                                                class="form-control shadow-sm" placeholder="Nhập email người nhận" required>
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

                    <div class="row mb-4">
                        <!-- Chi tiết đơn hàng -->
                        <div class="col-md-8 mb-4">
                            <h5 class="text-dark fw-semibold mb-3">Chi tiết đơn hàng</h5>
                            <ul class="nav nav-pills mb-3 border-bottom" id="pills-tab" role="tablist">
                                @foreach ($categories as $index => $category)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                            id="pills-category-{{ $category->id }}-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-category-{{ $category->id }}" type="button"
                                            role="tab" aria-controls="pills-category-{{ $category->id }}"
                                            aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                            <p class="p-0" style="font-size: 16px; margin-bottom: 0px;">
                                                {{ $category->tendanhmuc }}
                                            </p>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content variant-table" id="pills-tabContent">
                                @foreach ($categories as $index => $category)
                                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                        id="pills-category-{{ $category->id }}" role="tabpanel"
                                        aria-labelledby="pills-category-{{ $category->id }}-tab">
                                        @php
                                            $categoryProducts = $sanphams->where('id_danhmuc', $category->id);
                                        @endphp
                                        @if ($categoryProducts->isEmpty())
                                            <p class="text-center text-muted">Chưa có sản phẩm nào</p>
                                        @else
                                            <div class="row">
                                                @foreach ($categoryProducts as $sanpham)
                                                    @foreach ($sanpham->bienthe as $bienthe)
                                <div class="col-md-4 mb-3">
                                    <div class="card border-0 h-100 shadow-sm variant-card"
                                                                data-id="{{ $bienthe->id }}" >
                                    <input type="hidden"
                                                                    name="order_items[{{ $bienthe->id }}][id_bienthe]"
                                                                    value="{{ $bienthe->id }}" class="variant-hidden">
                                        <div class="position-relative" style="over-flow:hidden;">
                                                                    @if ($bienthe->hinh && file_exists(public_path('storage/' . $bienthe->hinh)))
                                        <img src="{{ asset('storage/' . $bienthe->hinh) }}"
                                                                            class=" rounded" alt="{{ $sanpham->tensp }}" style="width:100%; height: auto; object-fit: cover;">
                                    @else
                                    <img src="{{ asset('images/placeholder.jpg') }}"
                                                                            class=" rounded" alt="No Image"
                                                                            style="width:100px; height: auto; object-fit: cover;">
                                    @endif
                                        <span class="product-name fw-semibold position-absolute bottom-0 start-0  p-1 text-white "
                                                                        style="background: rgba(0, 0, 0, 0.6); font-size: 14px;">
                                                                        {{ $sanpham->tensp }}
                                                                    </span>
                                                                    <!-- Khối lượng và nhân bánh -->
                                                                    <div
                                                                        class="variant-info position-absolute top-0 end-0 p-2  text-white rounded-bottom-left rounded-top-right">
                                                                        @if ($bienthe->khoiluong)
                                                                            <span
                                                                                class="d-block text-center bg-warning">{{ $bienthe->khoiluong->khoiluong }}g</span>
                                                                        @endif
                                                                        @if ($bienthe->nhanbanh)
                                                                            <span
                                                                                class="d-block text-center bg-success">{{ $bienthe->nhanbanh->tenNhanBanh }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-flex flex-column">
                                                                            <p class="card-text price text-success"
                                                                                data-gia="{{ $bienthe->gia }}"
                                                                                data-giakm="{{ $bienthe->giakm ?? $bienthe->gia }}">
                                                                                @if ($bienthe->giakm && $bienthe->giakm < $bienthe->gia)
                                                                                    <del
                                                                                        class="text-danger">{{ number_format($bienthe->gia) }}₫</del>
                                                                                    <span
                                                                                        class="text-success ms-2">{{ number_format($bienthe->giakm) }}₫</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-success">{{ number_format($bienthe->gia) }}₫</span>
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                        <div class="mb-2 d-flex">
                                                                            <input type="number"
                                                                                name="order_items[{{ $bienthe->id }}][soluong]"
                                                                                class="form-control order-soluong"
                                                                                min="0" value="0"
                                                                                max="{{ $bienthe->soluong }}"
                                                                                style="width: 80px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Thông tin thanh toán -->
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-3">
                                <div class="card-header">
                                    <h5>Thông tin thanh toán</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Phương thức thanh toán -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="thanhtoan"
                                                id="thanhtoan" checked value="pay_later">
                                            <label class="form-check-label" for="thanhtoan">
                                                Thanh toán khi nhận hàng
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Phương thức vận chuyển -->
                                    <div class="mb-3">
                                        <label>Phương thức vận chuyển</label>
                                        <select name="vanchuyen" class="form-control">
                                            <option value="">Chọn phương thức vận chuyển</option>
                                            <option value="fast">Nhanh</option>
                                            <option value="superFast">Hỏa tốc</option>
                                        </select>
                                    </div>
                                    <!-- Voucher -->
                                    <div class="mb-3">
                                        <label>Voucher</label>
                                        <div style="max-height: 150px; overflow-y: auto;" class="border p-2 rounded">
                                            <div class="d-flex flex-column gap-2" id="voucher-list">
                                                @forelse ($vouchers as $voucher)
                                                    <div class="voucher-card-container">
                                                        <div class="voucher-card">
                                                            <input type="radio" id="voucher{{ $voucher->id }}"
                                                                name="id_giamgia" value="{{ $voucher->id }}"
                                                                data-sotien="{{ $voucher->hesogiamgia }}"
                                                                data-sotientoithieu="{{ $voucher->sotientoithieu }}"
                                                                class="voucher-input d-none">
                                                            <label for="voucher{{ $voucher->id }}"
                                                                class="voucher-label d-flex align-items-center justify-content-center position-relative">
                                                                <div class="voucher-content text-center">
                                                                    <span
                                                                        class="voucher-title">{{ $voucher->magiamgia ?? 'Giảm giá' }}</span>
                                                                    <span
                                                                        class="voucher-value">{{ number_format($voucher->sotientoithieu, 0, ',', '.') }}Đ</span>
                                                                    <span class="voucher-radio position-absolute"></span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-center text-muted">Không có voucher nào khả dụng.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Tạm tính</label>
                                        <span id="tam-tinh">0₫</span>
                                        <input type="hidden" name="tongtien" id="tongtien" value="0">
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Tiền giảm</label>
                                        <span id="tien-giam" class="text-danger">0₫</span>
                                        <input type="hidden" name="sotiengiam" id="sotiengiam" value="0">
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Tiền vận chuyển</label>
                                        <span id="tien-vc">0₫</span>
                                        <input type="hidden" name="tienvc" id="tienvc" value="0">
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <label>Thành tiền</label>
                                        <span id="thanh-tien">0₫</span>
                                        <input type="hidden" name="thanhtien" id="thanhtien" value="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Trạng thái đơn hàng -->
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <label for="trangthai" class="form-label fw-semibold">Trạng thái đơn hàng</label>
                                    <select name="trangthai" id="trangthai" class="form-select shadow-sm" required>
                                        <option value="chờ xác nhận">Chờ xác nhận</option>
                                        <option value="đã xác nhận">Đã xác nhận</option>
                                        <option value="đang giao">Đang giao</option>
                                        <option value="hoàn thành">Hoàn thành</option>
                                        <option value="đã hủy">Hủy</option>
                                    </select>
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

        .card-full-height {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .variant-card {
            transition: transform 0.2s ease, background-color 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
        }

        .variant-card:hover {
            transform: scale(1.03);
        }

        .variant-card.selected {
            background-color: #e7f3ff;
            border: 2px solid #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        /* Tên sản phẩm trên ảnh */
        .product-name {
            font-size: 14px;
            line-height: 1.2;
            width:100%;
            height:50px;
            max-height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Khối lượng và nhân bánh */
        .variant-info {
            font-size: 12px;
            line-height: 1.4;
            max-width: 120px;
            text-align: right;
        }

        .variant-info span {
            /*background: rgba(0, 123, 255, 0.8);*/
            padding: 2px 6px;
            border-radius: 3px;
            margin-bottom: 2px;
        }

        /* Horizontal scrolling nav-pills */
        #pills-tab {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            padding-bottom: 10px;
            margin-bottom: 0;
            width: 100%;
            min-width: 100%;
            box-sizing: border-box;
            cursor: grab;
        }

        #pills-tab:active {
            cursor: grabbing;
        }

        #pills-tab::-webkit-scrollbar {
            display: none;
        }

        #pills-tab {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #pills-tab .nav-item {
            flex: 0 0 auto;
            min-width: 100px;
        }

        #pills-tab .nav-link {
            padding: 10px 20px;
            font-size: 16px;
            color: #333;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
            margin-right: 5px;
            text-align: center;
        }

        #pills-tab .nav-link:hover {
            background-color: #f1f1f1;
        }

        #pills-tab .nav-link.active {
            background: linear-gradient(45deg, #007bff, #00b4db);
            color: white;
            border-bottom: none;
        }

        #pills-tab .nav-link p {
            margin: 0;
        }

        /* Đảm bảo container cha không giới hạn cuộn */
        .col-md-8 {
            overflow: visible !important;
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

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Thiết lập CSRF token cho AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#id_user').on('change', function() {
                const option = $(this).find('option:selected');
                const infoBox = $('#user-info');

                const hoten = option.data('hoten');
                const email = option.data('email');
                const phone = option.data('phone');

                if (option.val()) {
                    infoBox.removeClass('d-none');
                    $('#info-hoten').text(hoten);
                    $('#info-email').text(email);
                    $('#info-phone').text(phone);
                    $('#tennguoinhan').val(hoten);
                    $('#email').val(email);
                    $('#phone').val(phone);
                } else {
                    infoBox.addClass('d-none');
                    $('#tennguoinhan, #email, #phone').val('');
                }
            });

            // Xử lý click card
            $('.variant-card').on('click', function(e) {
                // Tránh toggle khi click vào input số lượng
                if ($(e.target).is('.order-soluong')) return;

                $(this).toggleClass('selected');
                updateQuantityInput($(this));
                updateTotal();
            });

            // Cập nhật số lượng khi card được chọn/bỏ chọn
            function updateQuantityInput(card) {
                const quantityInput = card.find('.order-soluong');
                quantityInput.val(card.hasClass('selected') ? 1 : 0);
            }

            // Tính toán tổng tiền
            function updateTotal() {
                let tongtien = 0;

                $('.variant-card.selected').each(function() {
                    const card = $(this);
                    const priceCell = card.find('.price');
                    const gia = parseInt(priceCell.data('giakm')) > 0 ? parseInt(priceCell.data('giakm')) :
                        parseInt(priceCell.data('gia'));
                    const soluong = parseInt(card.find('.order-soluong').val()) || 0;
                    tongtien += gia * soluong;
                });

                // Tính tiền vận chuyển
                const vanchuyen = $('select[name="vanchuyen"]').val();
                const tienvc = vanchuyen === 'fast' ? 30000 : (vanchuyen === 'superFast' ? 50000 : 0);

                // Kiểm tra voucher
                $('.voucher-input').each(function() {
                    const sotientoithieu = parseInt($(this).data('sotientoithieu') || 0);
                    $(this).prop('disabled', sotientoithieu > tongtien);

                    if (sotientoithieu > tongtien && $(this).is(':checked')) {
                        $(this).prop('checked', false);
                    }
                });

                // Tiền giảm
                const selectedVoucher = $('input[name="id_giamgia"]:checked');
                const hesogiamgia = selectedVoucher.length && !selectedVoucher.prop('disabled') 
                            ? parseFloat(selectedVoucher.data('sotien') || 0) / 100 
                            : 0;

                const sotiengiam = tongtien * hesogiamgia;
                
                const thanhtien = tongtien - sotiengiam + tienvc;

                // Update giao diện
                $('#tam-tinh').text(formatCurrency(tongtien));
                $('#tien-giam').text('-' + formatCurrency(sotiengiam));
                $('#tien-vc').text(formatCurrency(tienvc));
                $('#thanh-tien').text(formatCurrency(thanhtien));
                //lưu vào database
                $('#tongtien').val(tongtien);
                $('#sotiengiam').val(sotiengiam);
                $('#tienvc').val(tienvc);
                $('#thanhtien').val(thanhtien);
            }

            function formatCurrency(num) {
                return Number(num).toLocaleString('vi-VN') + '₫';
            }

            $('.order-soluong, select[name="vanchuyen"], input[name="id_giamgia"]').on('change input', function() {
                updateTotal();
            });

            // Xử lý lỗi hình ảnh
            $('.card-img-top').on('error', function() {
                $(this).attr('src', '{{ asset('images/placeholder.jpg') }}');
                console.warn('Image not found:', $(this).attr('src'));
            });

            // AJAX submit form
            $('#order-form').on('submit', function(e) {
                e.preventDefault();

                // Xóa input của card không được chọn
                $('.variant-card').each(function() {
                    const card = $(this);
                    const hiddenInput = card.find('.variant-hidden');
                    const quantityInput = card.find('.order-soluong');
                    if (!card.hasClass('selected')) {
                        hiddenInput.remove();
                        quantityInput.remove();
                    }
                });

                const formData = new FormData(this);
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                $.ajax({
                    url: '{{ route('donhang.store') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(xhr) {
                        console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
                        $('#order-form button[type="submit"]').prop('disabled', true).text(
                            'Đang xử lý...');
                    },
                    success: function(response) {
                        console.log('Success Response:', response);
                        if (response.success) {
                            showAlert('success', response.message ||
                                'Tạo đơn hàng thành công!');
                            setTimeout(() => {
                                window.location.href = '{{ route('donhang.index') }}';
                            }, 1500);
                        } else {
                            showAlert('danger', response.message ||
                                'Có lỗi xảy ra, vui lòng thử lại.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error details:', xhr.status, xhr.responseText);
                        let errorMessage = 'Có lỗi xảy ra, vui lòng kiểm tra lại.';
                        if (xhr.status === 403) {
                            errorMessage = 'Không có quyền tạo đơn hàng hoặc token không hợp lệ.';
                        } else if (xhr.responseJSON?.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('<br>');
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showAlert('danger', errorMessage);
                    },
                    complete: function() {
                        $('#order-form button[type="submit"]').prop('disabled', false).html(
                            '<i class="bi bi-save"></i> Tạo đơn hàng');
                    }
                });
            });

            function showAlert(type = 'success', message = '') {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                `;
                $('body').prepend(alertHtml);
                setTimeout(() => $('.alert').fadeOut(), 3000);
            }

            // Xử lý kéo chuột và cuộn bánh xe cho #pills-tab
            const tabs = $('#pills-tab');
            let isDown = false;
            let startX;
            let scrollLeft;

            tabs.on('mousedown', function(e) {
                isDown = true;
                startX = e.pageX - tabs.offset().left;
                scrollLeft = tabs.scrollLeft();
                tabs.css('cursor', 'grabbing');
            });

            tabs.on('mouseleave', function() {
                isDown = false;
                tabs.css('cursor', 'grab');
            });

            tabs.on('mouseup', function() {
                isDown = false;
                tabs.css('cursor', 'grab');
            });

            tabs.on('mousemove', function(e) {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - tabs.offset().left;
                const walk = (x - startX) * 2;
                tabs.scrollLeft(scrollLeft - walk);
            });

            tabs.on('wheel', function(e) {
                e.preventDefault();
                const delta = e.originalEvent.deltaY || e.originalEvent.deltaX;
                tabs.scrollLeft(tabs.scrollLeft() + delta * 2);
            });

            tabs.on('touchstart', function(e) {
                isDown = true;
                startX = e.originalEvent.touches[0].pageX - tabs.offset().left;
                scrollLeft = tabs.scrollLeft();
            });

            tabs.on('touchend', function() {
                isDown = false;
            });

            tabs.on('touchmove', function(e) {
                if (!isDown) return;
                const x = e.originalEvent.touches[0].pageX - tabs.offset().left;
                const walk = (x - startX) * 2;
                tabs.scrollLeft(scrollLeft - walk);
            });

            updateTotal();
        });
    </script>
@endsection