@extends('page.layout')
@section('title', 'Quản lý Banner')
@section('content')
    <div class="container-fluid p-3 p-md-3">
        <div class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-images text-primary bg-light p-4 rounded fs-4"></i>
                <div>
                    <h4 class="text-dark mb-0 fw-bold">Quản lý Banner</h4>
                    <small class="text-muted">Danh sách các banner hiển thị trên trang chủ</small>
                </div>
            </div>
            <div class="ms-auto">
                <a href="{{ route('banners.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Thêm Banner
                </a>
            </div>
        </div>

        <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-dark fw-bold">
                            <tr>
                                <th class="ps-4">Thứ tự</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Trạng thái</th>
                                <th class="text-end pe-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $banner->thutu }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $banner->hinhanh) }}" alt="{{ $banner->tieude }}" 
                                             class="rounded shadow-sm" style="width: 150px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>{{ $banner->tieude ?? 'Không có tiêu đề' }}</td>
                                    <td><small class="text-muted">{{ $banner->duongdan ?? '#' }}</small></td>
                                    <td>
                                        @if($banner->anhien == 1)
                                            <form action="{{ route('banners.unactive', $banner->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="badge bg-success border-0">Hiện</button>
                                            </form>
                                        @else
                                            <form action="{{ route('banners.active', $banner->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="badge bg-danger border-0">Ẩn</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" 
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Chưa có banner nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
