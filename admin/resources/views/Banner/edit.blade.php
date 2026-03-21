@extends('page.layout')
@section('title', 'Cập nhật Banner')
@section('content')
    <div class="container-fluid p-3 p-md-3">
        <div class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-pencil-square text-warning bg-light p-4 rounded fs-4"></i>
                <div>
                    <h4 class="text-dark mb-0 fw-bold">Cập nhật Banner</h4>
                    <small class="text-muted">Chỉnh sửa thông tin banner ID: {{ $banner->id }}</small>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
            <div class="card-body p-4 text-dark">
                <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tiêu đề</label>
                                <input type="text" name="tieude" class="form-control" value="{{ $banner->tieude }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Đường dẫn khi click</label>
                                <input type="text" name="duongdan" class="form-control" value="{{ $banner->duongdan }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thứ tự hiển thị</label>
                                <input type="number" name="thutu" class="form-control" value="{{ $banner->thutu }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Trạng thái</label>
                                <select name="anhien" class="form-select">
                                    <option value="1" {{ $banner->anhien == 1 ? 'selected' : '' }}>Hiện</option>
                                    <option value="0" {{ $banner->anhien == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hình ảnh mới (Để trống nếu không muốn đổi)</label>
                                <input type="file" name="hinhanh" class="form-control" accept="image/*">
                                <div class="mt-3">
                                    <p class="small text-muted mb-1">Ảnh hiện tại:</p>
                                    <img src="{{ asset('storage/' . $banner->hinhanh) }}" alt="{{ $banner->tieude }}" 
                                         class="rounded shadow-sm" style="width: 300px; height: 120px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('banners.index') }}" class="btn btn-outline-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
