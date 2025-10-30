@extends('page.layout')
@section('title', 'Đơn hàng')
@section('content')
    <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2"><i class="bi bi-arrow-left"></i> Trở lại</a>

        <!-- Form lọc dữ liệu -->
        <div class="container-fluid bg-white mt-4 p-3 mb-5 rounded shadow-sm">
            <form id="filterForm" class="d-flex align-items-center gap-3">
                <div class="form-group">
                    <label for="fromDate" class="text-dark fw-semibold">Từ ngày:</label>
                    <input type="date" id="fromDate" name="fromDate" class="form-control w-auto"
                        value="{{ now()->subMonth()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="toDate" class="text-dark fw-semibold">Đến ngày:</label>
                    <input type="date" id="toDate" name="toDate" class="form-control w-auto"
                        value="{{ now()->toDateString() }}">
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>

            <!-- Tabs -->
            <ul class="nav nav-tabs mt-3">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#ordersChart">Thống kê đơn hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#revenueChart">Thống kê doanh thu</a>
                </li>
            </ul>

            <!-- Nội dung của từng Tab -->
            <div class="tab-content mt-3">
                <div id="ordersChart" class="tab-pane fade show active">
                    <canvas id="ordersChartCanvas"></canvas>
                </div>
                <div id="revenueChart" class="tab-pane fade">
                    <canvas id="revenueChartCanvas"></canvas>
                </div>
            </div>
        </div>

        <!-- Quản lý đơn hàng -->
        <div class="container d-flex bg-white shadow-sm rounded align-items-center mt-4 mb-4 p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-bookmark text-danger bg-light p-3 rounded fs-4"></i>
                <h5 class="text-dark mb-0">Quản lý đơn hàng</h5>
            </div>
            <div class="ms-auto">
                <a href="{{ route('donhang.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus fs-5"></i> Đơn hàng
                </a>
            </div>
        </div>

        <!-- Bộ lọc trạng thái và ngày -->
        <div class="card bg-white shadow-sm border-0 text-dark mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-3 align-items-center">
                        <a href="{{ route('donhang.index') }}" class="btn btn-outline-primary">Tất cả</a>
                        <a href="{{ route('donhang.index') }}?status=chờ xác nhận" class="btn btn-outline-primary">Chờ
                            duyệt</a>
                        <a href="{{ route('donhang.index') }}?status=đã xác nhận" class="btn btn-outline-primary">Đã xác
                            nhận</a>
                        <a href="{{ route('donhang.index') }}?status=đang giao" class="btn btn-outline-primary">Đang
                            giao</a>
                    </div>
                    <form action="{{ route('donhang.date') }}" method="GET" class="d-flex align-items-center gap-2">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                            <input type="date" id="from" name="from" class="form-control"
                                value="{{ request('from') }}">
                        </div>
                        <span class="text-muted">đến</span>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                            <input type="date" id="to" name="to" class="form-control"
                                value="{{ request('to') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>

                <!-- Bảng đơn hàng -->
                <table class="table table-hover table-white">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">STT</th>
                            <th scope="col">Tên người dùng</th>
                            <th scope="col">Thanh toán</th>
                            <th scope="col">Thời gian đặt</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tổng cộng</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                            @foreach ($orders as $order)
                                <tr class="text-center">
                                    <td>#DH{{$order->id}}</td>
                                    <td>{{ $order->user->hoten }}</td>
                                    <td>{{$order->thanhToan->phuongthucthanhtoan}}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('donhang.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            @if ($errors->has('trangthai'))
                                                <div class="alert alert-danger">{{ $errors->first('trangthai') }}</div>
                                            @endif
                                            <select name="trangthai" class="form-control text-center"
                                                onchange="this.form.submit()">
                                                <option value="chờ xác nhận"
                                                    {{ $order->trangthai == 'chờ xác nhận' ? 'selected' : '' }}>Chờ xác
                                                    nhận</option>
                                                <option value="đã xác nhận"
                                                    {{ $order->trangthai == 'đã xác nhận' ? 'selected' : '' }}>Đã xác nhận
                                                </option>
                                                <option value="đang giao"
                                                    {{ $order->trangthai == 'đang giao' ? 'selected' : '' }}>Đang giao
                                                </option>
                                                <option value="hoàn thành"
                                                    {{ $order->trangthai == 'hoàn thành' ? 'selected' : '' }}>Hoàn thành
                                                </option>
                                                <option value="hủy" {{ $order->trangthai == 'hủy' ? 'selected' : '' }}>
                                                    Hủy</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ number_format($order->thanhtien, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <a href="{{ route('donhang.show', $order->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye fs-5"></i>
                                        </a>
                                        <a href="{{ route('donhang.edit', $order->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil fs-5"></i>
                                        </a>
                                        <form action="{{ route('donhang.destroy', $order->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Xác nhận xóa đơn hàng?')">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                       
                    </tbody>
                 
                </table>
                   <div class="d-flex justify-content-center mt-3">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let ordersChart, revenueChart;

            function loadChartData(fromDate, toDate) {
                $.ajax({
                    url: "{{ route('donhang.getChartData') }}",
                    method: "GET",
                    data: {
                        fromDate,
                        toDate
                    },
                    success: function(response) {
                        if (response.success === false) {
                            alert(response.message);
                            return;
                        }

                        const labels = response.labels.map(date => {
                            const [year, month, day] = date.split('-');
                            return `${day}/${month}`;
                        });
                        const orderData = response.orders;
                        const revenueData = response.revenue;

                        if (ordersChart) ordersChart.destroy();
                        if (revenueChart) revenueChart.destroy();

                        ordersChart = new Chart(document.getElementById("ordersChartCanvas").getContext(
                            "2d"), {
                            type: "bar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Số đơn hàng",
                                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    data: orderData,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        revenueChart = new Chart(document.getElementById("revenueChartCanvas")
                            .getContext("2d"), {
                                type: "line",
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: "Doanh thu (VNĐ)",
                                        backgroundColor: "rgba(255, 99, 132, 0.5)",
                                        borderColor: "rgba(255, 99, 132, 1)",
                                        data: revenueData,
                                        fill: true
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                    },
                    error: function() {
                        alert('Không thể tải dữ liệu biểu đồ. Vui lòng thử lại.');
                    }
                });
            }

            // Tải dữ liệu ban đầu
            loadChartData('', '');

            // Xử lý form lọc
            $("#filterForm").on("submit", function(e) {
                e.preventDefault();
                const fromDate = $("#fromDate").val();
                const toDate = $("#toDate").val();
                if (fromDate && toDate && fromDate > toDate) {
                    alert('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.');
                    return;
                }
                loadChartData(fromDate, toDate);
            });
        });
    </script>
@endsection
