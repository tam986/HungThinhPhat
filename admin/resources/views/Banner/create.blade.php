@extends('page.layout')
@section('title', 'Thêm Banner')
@section('content')
    <div class="container-fluid p-3 p-md-3">
        <div class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-plus-circle text-success bg-light p-4 rounded fs-4"></i>
                <div>
                    <h4 class="text-dark mb-0 fw-bold">Thêm Banner</h4>
                    <small class="text-muted">Tạo banner quảng cáo mới</small>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
            <div class="card-body p-4 text-dark">
                <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tiêu đề</label>
                                <input type="text" name="tieude" class="form-control" placeholder="Nhập tiêu đề banner">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Đường dẫn khi click</label>
                                <input type="text" name="duongdan" class="form-control" placeholder="/sanpham/cake-1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thứ tự hiển thị</label>
                                <input type="number" name="thutu" class="form-control" value="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Trạng thái</label>
                                <select name="anhien" class="form-select">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hình ảnh (Max 5MB)</label>
                                <input type="file" name="hinhanh" class="form-control" accept="image/*" required>
                                <div class="form-text text-muted">Kích thước gợi ý: 1920x600px</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('banners.index') }}" class="btn btn-outline-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
