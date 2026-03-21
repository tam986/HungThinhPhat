@extends('Profile')
@section('title', 'Trang chủ')
@section('subtitle', 'Thông tin cá nhân')
@section('subsubtitle', 'Đơn hàng của tôi')
@section('subtitle_url')
    {{ route('profile.profileUser') }}
@endsection
@section('profile_content')
    <div class="pt-3">
        <!-- Title -->
        <div class="container rounded shadow-sm p-2 d-flex align-items-center bg-white mb-4">
            <h4 class="title-profile mb-0 fs-4 fs-md-3">My Order</h4>
        </div>

        <!-- Tabs using Bootstrap 5 nav-pills -->
        <div class="container">
            <ul class="nav nav-pills mb-3 flex-wrap" id="pills-tab" role="tablist">
                <li class="nav-item me-2 mb-2" role="presentation">
                    <button class="nav-link active px-3 py-2" id="pills-tatca-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-tatca" type="button" role="tab" aria-controls="pills-tatca"
                        aria-selected="true">Tất cả</button>
                </li>
                <li class="nav-item me-2 mb-2" role="presentation">
                    <button class="nav-link px-3 py-2" id="pills-pending-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-pending" type="button" role="tab" aria-controls="pills-pending"
                        aria-selected="false">Chờ xác nhận</button>
                </li>
                <li class="nav-item me-2 mb-2" role="presentation">
                    <button class="nav-link px-3 py-2" id="pills-confirmed-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-confirmed" type="button" role="tab" aria-controls="pills-confirmed"
                        aria-selected="false">Đã xác nhận</button>
                </li>
                <li class="nav-item me-2 mb-2" role="presentation">
                    <button class="nav-link px-3 py-2" id="pills-shipping-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-shipping" type="button" role="tab" aria-controls="pills-shipping"
                        aria-selected="false">Đang giao</button>
                </li>
                <li class="nav-item me-2 mb-2" role="presentation">
                    <button class="nav-link px-3 py-2" id="pills-done-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-done" type="button" role="tab" aria-controls="pills-done"
                        aria-selected="false">Hoàn thành</button>
                </li>
                <li class="nav-item me-2 mb-2" role="presentation">
                    <button class="nav-link px-3 py-2" id="pills-cancelled-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-cancelled" type="button" role="tab" aria-controls="pills-cancelled"
                        aria-selected="false">Đã huỷ</button>
                </li>
            </ul>

            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Tìm đơn hàng theo Mã đơn hàng" id="search-input"
                    name="search" value="{{ $search ?? '' }}">
                <button class="btn btn-outline-primary" type="button" id="search-button">Tìm đơn hàng</button>
            </div>

            <!-- Tab content -->
            <div class="tab-content mb-4" id="pills-tabContent">
                <!-- All Orders Tab -->
                <div class="tab-pane fade show active" id="pills-tatca" role="tabpanel" aria-labelledby="pills-tatca-tab"
                    tabindex="0">
                    @if ($orderAll->isEmpty())
                        <div class="order-empty text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Empty"
                                class="img-fluid" style="max-width: 150px;">
                            <p class="mt-3">Quý khách chưa có đơn hàng nào.</p>
                            <a href="#" class="btn btn-danger mt-2">TIẾP TỤC MUA HÀNG</a>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionAll">
                            @foreach ($orderAll as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-all-{{ $order->id }}" aria-expanded="false"
                                            aria-controls="flush-all-{{ $order->id }}">
                                            <div
                                                class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span class="fs-6 fw-bold">#MD{{ $order->id }}</span>
                                                <span class="fs-6">{{ $order->created_at->format('d.m.Y') }}</span>
                                                <span
                                                    class="badge text-uppercase
                                                    @if ($order->trangthai == 'chờ xác nhận') bg-warning 
                                                    @elseif($order->trangthai == 'đã xác nhận') bg-info 
                                                    @elseif($order->trangthai == 'đang giao') bg-primary 
                                                    @elseif($order->trangthai == 'hoàn thành') bg-success 
                                                    @else bg-danger @endif fs-6"
                                                    style="width: 150px;">
                                                    {{ $order->trangthai }}
                                                </span>
                                                <span class="fs-6">{{ number_format($order->tongtien, 0, ',', '.') }}
                                                    VNĐ</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="flush-all-{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionAll">
                                        <div class="accordion-body">
                                            <!-- Order Details -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Hình</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->donhangchitiet as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $item->bienthe->hinh) }}"
                                                                        alt="" style="width:100px; height: auto;">
                                                                </td>
                                                                <td>{{ $item->bienthe->sanpham->tensp }}</td>
                                                                <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $item->soluong }}</td>
                                                                <td>{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}
                                                                    VNĐ</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Thành tiền</td>
                                                            <td>{{ number_format($order->tongtien, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Vận chuyển</td>
                                                            <td>{{ number_format(30000, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total</strong>
                                                            </td>
                                                            <td><strong>{{ number_format($order->tongtien + 30000, 0, ',', '.') }}
                                                                    VNĐ</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-end flex-wrap gap-2 mt-3">

                                                @if ($order->trangthai == 'chờ xác nhận')
                                                    <form action="{{ route('donhang.huy', $order->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger">Hủy đơn</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- chờ duyệt -->
                <div class="tab-pane fade" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab"
                    tabindex="0">
                    @if ($pendingOrders->isEmpty())
                        <div class="order-empty text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Empty"
                                class="img-fluid" style="max-width: 150px;">
                            <p class="mt-3">Quý khách chưa có đơn hàng nào.</p>
                            <a href="#" class="btn btn-danger mt-2">TIẾP TỤC MUA HÀNG</a>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionPending">
                            @foreach ($pendingOrders as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-pending-{{ $order->id }}"
                                            aria-expanded="false" aria-controls="flush-pending-{{ $order->id }}">
                                            <div
                                                class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span class="fs-6 fw-bold">#MD{{ $order->id }}</span>
                                                <span class="fs-6">{{ $order->created_at->format('d.m.Y') }}</span>
                                                <span
                                                    class="badge bg-warning fs-6">{{ strtoupper($order->trangthai) }}</span>
                                                <span class="fs-6">{{ number_format($order->tongtien, 0, ',', '.') }}
                                                    VNĐ</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="flush-pending-{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionPending">
                                        <div class="accordion-body">
                                            <!-- Order Details -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Hình</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->donhangchitiet as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $item->bienthe->hinh) }}"
                                                                        alt="" style="width:100px; height: auto;">
                                                                </td>
                                                                <td>{{ $item->bienthe->sanpham->tensp }}</td>
                                                                <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $item->soluong }}</td>
                                                                <td>{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}
                                                                    VNĐ</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Thành tiền</td>
                                                            <td>{{ number_format($order->tongtien, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Vận chuyển</td>
                                                            <td>{{ number_format(30000, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total</strong>
                                                            </td>
                                                            <td><strong>{{ number_format($order->tongtien + 30000, 0, ',', '.') }}
                                                                    VNĐ</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-end flex-wrap gap-2 mt-3">

                                                @if ($order->trangthai == 'chờ xác nhận')
                                                    <form action="{{ route('donhang.huy', $order->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger">Hủy đơn</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- đã duyệt -->
                <div class="tab-pane fade" id="pills-confirmed" role="tabpanel" aria-labelledby="pills-confirmed-tab"
                    tabindex="0">
                    @if ($confirmedOrders->isEmpty())
                        <div class="order-empty text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Empty"
                                class="img-fluid" style="max-width: 150px;">
                            <p class="mt-3">Quý khách chưa có đơn hàng nào.</p>
                            <a href="#" class="btn btn-danger mt-2">TIẾP TỤC MUA HÀNG</a>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionConfirmed">
                            @foreach ($confirmedOrders as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-confirmed-{{ $order->id }}" aria-expanded="false"
                                            aria-controls="flush-confirmed-{{ $order->id }}">
                                            <div
                                                class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span class="fs-6 fw-bold">#MD{{ $order->id }}</span>
                                                <span class="fs-6">{{ $order->created_at->format('d.m.Y') }}</span>
                                                <span
                                                    class="badge bg-info fs-6">{{ strtoupper($order->trangthai) }}</span>
                                                <span class="fs-6">{{ number_format($order->tongtien, 0, ',', '.') }}
                                                    VNĐ</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="flush-confirmed-{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionConfirmed">
                                        <div class="accordion-body">
                                            <!-- Order Details -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Hình</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->donhangchitiet as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $item->bienthe->hinh) }}"
                                                                        alt="" style="width:100px; height: auto;">
                                                                </td>
                                                                <td>{{ $item->bienthe->sanpham->tensp }}</td>
                                                                <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $item->soluong }}</td>
                                                                <td>{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}
                                                                    VNĐ</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Thành tiền</td>
                                                            <td>{{ number_format($order->tongtien, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Vận chuyển</td>
                                                            <td>{{ number_format(30000, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total</strong>
                                                            </td>
                                                            <td><strong>{{ number_format($order->tongtien + 30000, 0, ',', '.') }}
                                                                    VNĐ</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- đang giao -->
                <div class="tab-pane fade" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab"
                    tabindex="0">
                    @if ($shippingOrders->isEmpty())
                        <div class="order-empty text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Empty"
                                class="img-fluid" style="max-width: 150px;">
                            <p class="mt-3">Quý khách chưa có đơn hàng nào.</p>
                            <a href="#" class="btn btn-danger mt-2">TIẾP TỤC MUA HÀNG</a>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionShipping">
                            @foreach ($shippingOrders as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-shipping-{{ $order->id }}" aria-expanded="false"
                                            aria-controls="flush-shipping-{{ $order->id }}">
                                            <div
                                                class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span class="fs-6 fw-bold">#MD{{ $order->id }}</span>
                                                <span class="fs-6">{{ $order->created_at->format('d.m.Y') }}</span>
                                                <span
                                                    class="badge bg-primary fs-6">{{ strtoupper($order->trangthai) }}</span>
                                                <span class="fs-6">{{ number_format($order->tongtien, 0, ',', '.') }}
                                                    VNĐ</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="flush-shipping-{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionShipping">
                                        <div class="accordion-body">
                                            <!-- Order Details -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Hình</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->donhangchitiet as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $item->bienthe->hinh) }}"
                                                                        alt="" style="width:100px; height: auto;">
                                                                </td>
                                                                <td>{{ $item->bienthe->sanpham->tensp }}</td>
                                                                <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $item->soluong }}</td>
                                                                <td>{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}
                                                                    VNĐ</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Thành tiền</td>
                                                            <td>{{ number_format($order->tongtien, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Vận chuyển</td>
                                                            <td>{{ number_format(30000, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total</strong>
                                                            </td>
                                                            <td><strong>{{ number_format($order->tongtien + 30000, 0, ',', '.') }}
                                                                    VNĐ</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- hoàn thành -->
                <div class="tab-pane fade" id="pills-done" role="tabpanel" aria-labelledby="pills-done-tab"
                    tabindex="0">
                    @if ($doneOrders->isEmpty())
                        <div class="order-empty text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Empty"
                                class="img-fluid" style="max-width: 150px;">
                            <p class="mt-3">Quý khách chưa có đơn hàng nào.</p>
                            <a href="#" class="btn btn-danger mt-2">TIẾP TỤC MUA HÀNG</a>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionDone">
                            @foreach ($doneOrders as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-done-{{ $order->id }}"
                                            aria-expanded="false" aria-controls="flush-done-{{ $order->id }}">
                                            <div
                                                class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span class="fs-6 fw-bold">#MD{{ $order->id }}</span>
                                                <span class="fs-6">{{ $order->created_at->format('d.m.Y') }}</span>
                                                <span
                                                    class="badge bg-success fs-6">{{ strtoupper($order->trangthai) }}</span>
                                                <span class="fs-6">{{ number_format($order->tongtien, 0, ',', '.') }}
                                                    VNĐ</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="flush-done-{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionDone">
                                        <div class="accordion-body">
                                            <!-- Order Details -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Hình</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->donhangchitiet as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $item->bienthe->hinh) }}"
                                                                        alt="" style="width:100px; height: auto;">
                                                                </td>
                                                                <td>{{ $item->bienthe->sanpham->tensp }}</td>
                                                                <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $item->soluong }}</td>
                                                                <td>{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}
                                                                    VNĐ</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Thành tiền</td>
                                                            <td>{{ number_format($order->tongtien, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Vận chuyển</td>
                                                            <td>{{ number_format(30000, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total</strong>
                                                            </td>
                                                            <td><strong>{{ number_format($order->tongtien + 30000, 0, ',', '.') }}
                                                                    VNĐ</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- hủy -->
                <div class="tab-pane fade" id="pills-cancelled" role="tabpanel" aria-labelledby="pills-cancelled-tab"
                    tabindex="0">
                    @if ($cancelledOrders->isEmpty())
                        <div class="order-empty text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="Empty"
                                class="img-fluid" style="max-width: 150px;">
                            <p class="mt-3">Quý khách chưa có đơn hàng nào.</p>
                            <a href="#" class="btn btn-danger mt-2">TIẾP TỤC MUA HÀNG</a>
                        </div>
                    @else
                        <div class="accordion accordion-flush" id="accordionCancelled">
                            @foreach ($cancelledOrders as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-cancelled-{{ $order->id }}" aria-expanded="false"
                                            aria-controls="flush-cancelled-{{ $order->id }}">
                                            <div
                                                class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span class="fs-6 fw-bold">#MD{{ $order->id }}</span>
                                                <span class="fs-6">{{ $order->created_at->format('d.m.Y') }}</span>
                                                <span
                                                    class="badge bg-danger fs-6">{{ strtoupper($order->trangthai) }}</span>
                                                <span class="fs-6">{{ number_format($order->tongtien, 0, ',', '.') }}
                                                    VNĐ</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="flush-cancelled-{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionCancelled">
                                        <div class="accordion-body">
                                            <!-- Order Details -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Hình</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->donhangchitiet as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $item->bienthe->hinh) }}"
                                                                        alt="" style="width:100px; height: auto;">
                                                                </td>
                                                                <td>{{ $item->bienthe->sanpham->tensp }}</td>
                                                                <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $item->soluong }}</td>
                                                                <td>{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}
                                                                    VNĐ</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Thành tiền</td>
                                                            <td>{{ number_format($order->tongtien, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end">Vận chuyển</td>
                                                            <td>{{ number_format(30000, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total</strong>
                                                            </td>
                                                            <td><strong>{{ number_format($order->tongtien + 30000, 0, ',', '.') }}
                                                                    VNĐ</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script>
        document.getElementById('search-button').addEventListener('click', function() {
            const searchValue = document.getElementById('search-input').value;
            const url = new URL(window.location.href);
            if (searchValue) {
                url.searchParams.set('search', searchValue);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        });
    </script>
@endsection
