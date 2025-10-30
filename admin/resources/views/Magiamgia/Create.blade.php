@extends('page.layout')
@section('title', 'Tạo mã giảm giá')
@section('content')
    <div class="container mt-4">
        <h2 class="text-dark mb-4 text-center">Thêm Mã Giảm Giá Mới</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('magiamgia.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="magiamgia" class="form-label text-dark">Mã Giảm Giá:</label>
                        <input type="text" name="magiamgia" id="magiamgia" class="form-control @error('magiamgia') is-invalid @enderror" value="{{ old('magiamgia') }}" required>
                        @error('magiamgia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hesogiamgia" class="form-label text-dark">Hệ Số Giảm Giá (%):</label>
                        <input type="number" step="0.01" name="hesogiamgia" id="hesogiamgia" class="form-control @error('hesogiamgia') is-invalid @enderror" value="{{ old('hesogiamgia') }}" min="0" required>
                         @error('hesogiamgia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sotientoithieu" class="form-label text-dark">Số Tiền Tối Thiểu (VNĐ):</label>
                        <input type="number" step="1" name="sotientoithieu" id="sotientoithieu" class="form-control @error('sotientoithieu') is-invalid @enderror" value="{{ old('sotientoithieu') }}" min="0" required>
                         @error('sotientoithieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="thoidiembatdau" class="form-label text-dark">Thời Điểm Bắt Đầu:</label>
                            <input type="datetime-local" name="thoidiembatdau" id="thoidiembatdau" class="form-control @error('thoidiembatdau') is-invalid @enderror" value="{{ old('thoidiembatdau', $now ?? '') }}" required>
                             @error('thoidiembatdau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="thoidiemketthuc" class="form-label text-dark">Thời Điểm Kết Thúc:</label>
                            <input type="datetime-local" class="form-control @error('thoidiemketthuc') is-invalid @enderror" id="thoidiemketthuc" name="thoidiemketthuc"
                                min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                                value="{{ old('thoidiemketthuc', isset($magiamgia->thoidiemketthuc) ? date('Y-m-d\TH:i', strtotime($magiamgia->thoidiemketthuc)) : '') }}"
                                required>
                             @error('thoidiemketthuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="soluong" class="form-label text-dark">Số Lượng:</label>
                        <input type="number" name="soluong" id="soluong" class="form-control @error('soluong') is-invalid @enderror" value="{{ old('soluong') }}" min="1" required>
                         @error('soluong')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="trangthai" class="form-label text-dark">Trạng Thái:</label>
                        <select name="trangthai" id="trangthai" class="form-select @error('trangthai') is-invalid @enderror">
                            <option value="0" {{ old('trangthai') == '0' ? 'selected' : '' }}>Hiển thị</option>
                            <option value="1" {{ old('trangthai') == '1' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                         @error('trangthai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i> Thêm Mã Giảm Giá
                        </button>
                        <a href="{{ route('magiamgia.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times-circle me-2"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection