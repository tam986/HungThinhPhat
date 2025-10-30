@extends('page.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid p-4">
        <div class="container-fluid mt-4">
            <div class="container-fluid mb-4 p-0">
                <div class="container-fluid d-flex justify-content-end align-items-center flex-column p-0">
                    <h1 class="text-dark">Xin chào, {{ Auth::user()->hoten }}</h1>
                    <p class="text-dark">Chúc bạn một ngày tốt lành</p>
                </div>
            </div>
            <h2 class="text-dark mb-4">Trang Dashboard</h2>

            <!-- Thống kê -->
            <div class="row text-dark mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-white shadow-sm p-3 ">
                        <div class="d-flex justify-content-between align-items-center ">
                            <div class="container-fluid">
                                <i class="bi bi-pie-chart-fill  fs-1" style="color: #007bff"></i>
                            </div>
                            <div class="container-fluid  d-flex  align-items-start flex-column gap-1">

                                <span id="totalRevenue" class="text-primary fs-1">
                                    {{ number_format($tongDoanhThuThangNay, 0, ',', '.') }}
                                </span>
                                <span class="text-muted">Tổng Thu</span>
                                <span id="changePercentage"
                                    class="{{ $phanTramDoanhThu >= 0 ? 'text-success' : 'text-danger' }}">
                                    Tăng {{ number_format($phanTramDoanhThu, 2) }}%
                            </div>

                        </div>


                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-white border-0 shadow-sm p-3">
                        <div class="d-flex justify-content-between  align-items-center ">
                            <div class="container-fluid">
                                <i class="bi bi-book text-success fs-1"></i>
                            </div>
                            <div class="container-fluid  d-flex  align-items-start flex-column gap-1">
                                <span class="text-success fs-1">{{ $tongbaiviet }}</span>
                                <span class="text-dark ">Bài viết</span>
                                <span class="text-dark "> <i class="bi bi-graph-up-arrow text-success"> </i> Tăng</span>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-white shadow-sm p-3">
                        <div class="d-flex justify-content-between  align-items-center ">
                            <div class="container-fluid">
                                <i class="bi bi-cake2-fill fs-1" style="color: #da624a"></i>
                            </div>
                            <div class="container-fluid  d-flex  align-items-start flex-column gap-1">
                                <span class=" fs-1"style="color: #da624a">{{ $tongsanpham }}</span>
                                <span class="text-dark ">Sản phẩm</span>
                                <span class="text-dark "> <i class="bi bi-graph-up-arrow text-success"> </i> Tăng</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-white shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center ">
                            <div class="container-fluid">
                                <i class="bi bi-bag-check  fs-1" style="color: #d92550"></i>
                            </div>
                            <div class="container-fluid  d-flex  align-items-start flex-column gap-1">
                                <span class="fs-1" style="color: #d92550">{{ $tongdonhangmoi }}</span>
                                <span class="text-dark ">Đơn hàng</span>
                                <span class="text-dark "> <i class="bi bi-graph-up-arrow text-success"> </i> Tăng
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ -->
            <h5 class="text-dark">Thống kê doanh thu</h5>
            <div class="row mt-3 mb-3 gap-4 ">
                <div class="col-md-9 bg-white shadow-sm rounded p-3 ml-3" style="width:74.2%">
                    @include('page.Chart')
                </div>
                <div class="col-md-3 border-0 card bg-white shadow-sm rounded p-3" style="width:23%">
                    <h4 class="text-dark">Danh sách khách hàng mới</h4>
                    <p class="text-dark">Hiển thị các khách hàng mới đăng ký</p>
                    <div class="container d-flex justify-content-center align-items-center">
                        <ul class="container p-0 m-0">
                            @foreach ($listkhachhangmoi as $user)
                                <li class="container d-flex gap-4 align-items-center mb-3 mt-3">
                                    <div class="container pl-0" style="width:100px; heigh:100px">
                                        <img class="d-block w-100 h-100 rounded"
                                            src="{{ $user->hinh ? asset('storage/' . $user->hinh) : asset('img-user/_default-user.png') }}"
                                            alt="User">
                                    </div>
                                    <div class="container d-flex flex-column">
                                        <span class="text-dark" style="font-size: 13px">
                                            <strong>{{ $user->hoten }}</strong> </span>
                                        <span class="text-success"
                                            style="font-size: 12px">{{ $user->quyen == 1 ? 'Admin' : 'Customer' }}</span>
                                    </div>

                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <!-- bài viết và danh mục -->
            <div class="row mt-3 mb-3 gap-4 ">
                <div class="col-md-9 bg-white shadow-sm rounded p-3 ml-3" style="width:74.2%">
                    <div class="container-fluid">
                        @include('page.Baiviet')
                    </div>
                </div>

                <div class="col-md-3 card border-0   bg-white shadow-sm rounded " style="width:23%">
                    <div class="card-header bg-white p-2 mt-4">
                        <h5 class="text-dark">Danh sách danh mục</h5>
                        <span class="text-dark fs-6"><i>Hiển thị số lượng sản phẩm đang có trong danh mục</i> </span>
                    </div>
                    <div class="card-body p-0">
                        @foreach ($danhmucCountSP as $danhmuc)
                            <div class="container-fluid d-flex flex-column mt-3">
                                <div class="container-fluid">
                                    <span class="text-dark"> {{ $danhmuc->tendanhmuc }}</span>
                                </div>

                                <div class="container-fluid d-flex mb-3"> <span class="text-secondary">có
                                        ({{ $danhmuc->so_sanpham }})
                                        sản phẩm</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="{{ route('danhmucDM.index') }}" class="btn btn-success ">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let canvas = document.getElementById("myChart");
            let ctx = canvas.getContext("2d");

            // Dữ liệu giả lập (Doanh thu theo ngày)
            const xValues = ["01/03", "02/03", "03/03", "04/03", "05/03", "06/03", "07/03"];
            const yValues = [8, 10, 12, 7, 9, 15, 11]; // Giả lập số đơn hàng mỗi ngày

            // Kiểm tra nếu không có dữ liệu
            if (yValues.length === 0) {
                canvas.style.display = "none"; // Ẩn canvas nếu không có dữ liệu
                let noDataMessage = document.createElement("p");
                noDataMessage.innerText = "Không có dữ liệu để hiển thị!";
                noDataMessage.style.color = "white";
                noDataMessage.style.textAlign = "center";
                noDataMessage.style.fontSize = "18px";
                canvas.parentNode.appendChild(noDataMessage);
                return;
            }

            // Nếu có dữ liệu, vẽ biểu đồ
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        label: "Số đơn hàng",
                        backgroundColor: "rgba(0,0,255,0.1)",
                        borderColor: "rgba(247, 247, 254, 0.95)",
                        data: yValues,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: "top",
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: "Ngày"
                            }
                        },
                        y: {
                            min: 0,
                            title: {
                                display: true,
                                text: "Số đơn hàng"
                            }
                        }
                    }
                }
            });
        });
    </script>


@endsection
