@extends('page.layout')
@section('title','Thống kê')
@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-dark">📊 Thống kê</h1>

    <!-- Bộ lọc ngày -->
    <form method="GET" action="{{ route('thongke.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="date" name="from" class="form-control" value="{{ $from }}">
        </div>
        <div class="col-md-4">
            <input type="date" name="to" class="form-control" value="{{ $to }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100"><i class="fa fa-filter"></i> Lọc thống kê</button>
        </div>
    </form>

    <!-- Tổng quan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h5><i class="fa fa-check-circle text-success"></i> Tổng đơn hàng đã giao</h5>
                <h2>{{ $tongDonHang }}</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h5><i class="fa fa-money-bill-wave text-primary"></i> Tổng doanh thu</h5>
                <h2>{{ number_format($tongDoanhThu, 0, ',', '.') }} đ</h2>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Top sản phẩm bán chạy -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm h-100">
                <h5><i class="fa fa-fire text-danger"></i> Top 5 sản phẩm bán chạy</h5>
                <canvas id="topBanChayChart" height="150"></canvas>
            </div>
        </div>
    
        <!-- Bảng xếp hạng người dùng chi tiêu nhiều -->
        <div class="col-md-6">
            <div class="card shadow-sm p-4 h-100">
                <h4 class="mb-4">
                    <i class="fa fa-crown text-warning"></i> Bảng xếp hạng người dùng chi tiêu nhiều
                </h4>
                <div class="list-group">
                    @foreach ($topNguoiDungChiTieu as $i => $item)
                        @php
                            $rank = $i + 1;
                            $user = $item['user'];
                            $tong_chi = $item['tong_chi'];
                            $badgeColor = match($rank) {
                                1 => 'gold',
                                2 => 'silver',
                                3 => 'bronze',
                                default => 'secondary',
                            };
                        @endphp
    
                        <div class="list-group-item d-flex align-items-center justify-content-between px-3 py-2 {{ $rank <= 3 ? 'bg-light' : '' }}" style="border-left: 5px solid {{ $rank == 1 ? '#FFD700' : ($rank == 2 ? '#C0C0C0' : ($rank == 3 ? '#CD7F32' : '#dee2e6') ) }};">
                            <div class="d-flex align-items-center gap-3">
                                <span class="fs-4 fw-bold text-{{ $badgeColor }}">{{ $rank }}</span>
                                <img src="{{ $user->hinh ? asset('storage/' . $user->hinh) : 'https://ui-avatars.com/api/?name=' . urlencode($user->hoten) }}" alt="Avatar" class="rounded-circle" width="50" height="50">
                                <div>
                                    <div class="fw-semibold">{{ $user->hoten }}</div>
                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                {{ number_format($tong_chi, 0, ',', '.') }} đ
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>      
    <!-- Tabs bài viết -->
    <div class="card p-3 shadow-sm mb-4">
        <h5><i class="fa fa-book-open text-info"></i> Thống kê bài viết theo danh mục</h5>

        <ul class="nav nav-tabs mt-3" id="baivietTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="baiviet-tab" data-bs-toggle="tab" data-bs-target="#baiviet" type="button" role="tab">
                    <i class="fa fa-file-alt"></i> Số bài viết
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button" role="tab">
                    <i class="fa fa-eye"></i> Lượt xem
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="baiviet" role="tabpanel">
                <canvas id="baivietChart" height="100"></canvas>
            </div>
            <div class="tab-pane fade" id="view" role="tabpanel">
                <canvas id="viewChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Tồn kho nhiều -->
    <div class="card mb-4 p-3 shadow-sm">
        <h5><i class="fa fa-boxes text-success"></i> Top 5 sản phẩm tồn kho nhiều</h5>
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Tổng tồn</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topTonKhoNhieu as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ is_array($item) ? $item['tensp'] : $item->tensp }}</td>
                    <td><span class="badge bg-success">{{ $item['tong_ton'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tồn kho ít -->
    <div class="card mb-4 p-3 shadow-sm">
        <h5><i class="fa fa-box text-danger"></i> Top 5 sản phẩm tồn kho ít</h5>
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Tổng tồn</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topTonKhoIt as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ is_array($item) ? $item['tensp'] : $item->tensp }}</td>
                    <td><span class="badge bg-success">{{ $item['tong_ton'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bình luận -->
    <div class="card mb-4 p-3 shadow-sm">
        <h5><i class="fa fa-comments text-secondary"></i> 5 bình luận mới nhất</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Khối lượng</th>
                    <th>Nhân bánh</th>
                    <th>Người bình luận</th>
                    <th>Nội dung</th>
                    <th>Ngày</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topBinhLuanMoi as $item)
                    @php $bl = $item['binhluan_moi']; @endphp
                    <tr>
                        <td>{{ $item['sanpham']->tensp }}</td>
                        <td>{{ $item['khoiluong']->khoiluong }}</td>
                        <td>{{ $item['nhanbanh']->tenNhanBanh }}</td>
                        <td>{{ $bl->user->hoten ?? 'Ẩn danh' }}</td>
                        <td>{{ $bl->noidung }}</td>
                        <td>{{ $bl->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const blackLabelPlugin = {
        id: 'blackLabel',
        beforeDraw: chart => {
            chart.options.plugins.legend.labels.color = '#000';
            chart.options.scales.x.ticks.color = '#000';
            chart.options.scales.y.ticks.color = '#000';
        }
    };

    // Chart: Top bán chạy
    new Chart(document.getElementById('topBanChayChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topBanChay->pluck('bienthe.sanpham.tensp')) !!},
            datasets: [{
                label: 'Số lượng bán',
                data: {!! json_encode($topBanChay->pluck('tongban')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: '#000' } }
            },
            scales: {
                x: { ticks: { color: '#000' } },
                y: { beginAtZero: true, ticks: { color: '#000' } }
            }
        }
    });

    // Chart: Số bài viết
    new Chart(document.getElementById('baivietChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($baivietByDanhMuc->pluck('tendm')) !!},
            datasets: [{
                label: 'Số bài viết',
                data: {!! json_encode($baivietByDanhMuc->pluck('so_baiviet')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: '#000' } }
            },
            scales: {
                x: { ticks: { color: '#000' } },
                y: { beginAtZero: true, ticks: { color: '#000' } }
            }
        }
    });

    // Chart: Lượt xem
    new Chart(document.getElementById('viewChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($baivietByDanhMuc->pluck('tendm')) !!},
            datasets: [{
                label: 'Lượt xem',
                data: {!! json_encode($baivietByDanhMuc->pluck('tong_luotxem')) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: '#000' } }
            },
            scales: {
                x: { ticks: { color: '#000' } },
                y: { beginAtZero: true, ticks: { color: '#000' } }
            }
        }
    });
</script>
<style>
    .bg-gold { background-color: #fff8dc !important; }
    .bg-silver { background-color: #f8f9fa !important; }
    .bg-bronze { background-color: #faebd7 !important; }
</style>
@endsection
