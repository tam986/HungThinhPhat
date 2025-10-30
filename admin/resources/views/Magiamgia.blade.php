@extends('page.layout')

@section('title', 'Dashboard')
@section('subtitle', 'Quản lí mã giảm giá')

@section('content')
    <div class="container-fluid p-1 animate__animated animate__fadeInRight">

        {{-- Header và Thống kê --}}
        <div class="card bg-white shadow-sm rounded mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-4">
                    <div>
                        {{-- Sử dụng Bootstrap Icons (bi bi-...) hoặc Font Awesome (fas fa-...) --}}
                        <i class="bi bi-bookmark-fill text-danger bg-light p-3 rounded fs-4"></i>
                    </div>
                    <div>
                        <h5 class="text-dark mb-0">Quản lý mã giảm giá</h5>
                        <span class="text-muted">
                            Hiện <b class="text-primary">{{ $magiamgia->count() }}</b> trong
                            tổng <b class="text-success">{{ $magiamgia->total() }}</b> mã giảm giá
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <h2 class="text-dark mb-3">Danh Sách Mã Giảm Giá</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('magiamgia.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus-circle me-2"></i> Thêm Mã Giảm Giá
            </a>

            <div class="table-responsive">
                <table class="table table-hover"> {{-- Thêm table-striped cho dễ đọc --}}
                    <thead class="table-light text-dark">
                        <tr>
                            <th style="width: 5%;">ID</th> {{-- Thử đặt width cho cột nhỏ --}}
                            <th style="width: 15%;">Mã Giảm Giá</th>
                            <th style="width: 10%;">Giảm Giá</th>
                            <th style="width: 15%;">Tối Thiểu</th>
                            <th style="width: 8%;">Số Lượng</th>
                            <th style="width: 17%;">Thời Gian Còn Lại</th> {{-- Cột này cần đủ rộng cho countdown --}}
                            <th class="text-center" style="width: 10%;">Trạng Thái</th>
                            <th style="width: 20%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($magiamgia as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ is_array($item->magiamgia) ? implode(', ', $item->magiamgia) : $item->magiamgia }}</td>
                                <td>{{ $item->hesogiamgia }}%</td>
                                <td>{{ number_format($item->sotientoithieu) }} VND</td>
                                <td>{{ $item->soluong }}</td>
                                {{-- Thêm class và data-attribute cho JS countdown --}}
                                <td class="countdown-timer" data-endtime="{{ $item->thoidiemketthuc }}">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Đang tải...
                                </td>
                                <td class="text-center">
                                     {{-- Giả sử trường trạng thái là anhien --}}
                                    @if ($item->anhien == 0)
                                        <span class="badge bg-success"><i class="fas fa-eye me-1"></i> Hiển thị</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-eye-slash me-1"></i> Ẩn</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Nút hành động trên màn hình lớn --}}
                                    <div class="d-none d-md-inline-flex gap-2"> {{-- Sử dụng d-inline-flex và gap --}}
                                        <a href="{{ route('magiamgia.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('magiamgia.destroy', $item->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Bạn có thật sự muốn xóa mã giảm giá này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                    {{-- Dropdown hành động trên màn hình nhỏ --}}
                                    <div class="d-md-none dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Hành động
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('magiamgia.edit', $item->id) }}">Sửa</a></li>
                                            <li>
                                                <form action="{{ route('magiamgia.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Bạn có thật sự muốn xóa mã giảm giá này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Xóa</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Thêm phần phân trang nếu $magiamgia là một Paginator --}}
            {{ $magiamgia->links() }}

        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hàm để cập nhật thời gian đếm ngược cho một phần tử
        function updateCountdown(element) {
            const endTimeString = element.getAttribute('data-endtime');
            const endTime = new Date(endTimeString).getTime(); // Lấy timestamp của thời điểm kết thúc
            const now = new Date().getTime(); // Lấy timestamp hiện tại

            const timeLeft = endTime - now; // Thời gian còn lại tính bằng miliseconds

            const spinner = element.querySelector('.spinner-border'); // Tìm spinner
            if (spinner) {
                 spinner.remove(); // Xóa spinner sau lần cập nhật đầu tiên
            }


            if (timeLeft < 0) {
                element.innerHTML = '<span class="text-danger"><i class="fas fa-clock me-1"></i> Đã hết hạn</span>';
            } else {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                element.innerHTML = ` ${days} ngày ${hours} giờ ${minutes} phút ${seconds} giây`;
                
                if (days < 1 && hours < 24) {element.classList.add('text-warning');
                }
                 if (days < 1 && hours < 1) {
                    element.classList.remove('text-warning');
                    element.classList.add('text-danger');
                }
            }
        }

        // Lấy tất cả các phần tử có class countdown-timer
        const countdownElements = document.querySelectorAll('.countdown-timer');

        // Cập nhật ngay lần đầu tiên và sau đó mỗi giây
        countdownElements.forEach(element => {
            updateCountdown(element); // Cập nhật lần đầu
            // Cập nhật mỗi giây
            setInterval(function () {
                updateCountdown(element);
            }, 1000);
        });
    });
</script>
@endsection