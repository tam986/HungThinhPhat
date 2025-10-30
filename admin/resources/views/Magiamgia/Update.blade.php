@extends('page.layout')
@section('title', 'Chỉnh sửa mã giảm giá')
@section('content')
    <div class="container mt-4">
        <h2 class="text-dark mb-4 text-center">Chỉnh sửa Mã Giảm Giá</h2>

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
                <form action="{{ route('magiamgia.update', $magiamgia->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="magiamgia" class="form-label text-dark">Mã Giảm Giá:</label>
                        <input type="text" class="form-control @error('magiamgia') is-invalid @enderror" id="magiamgia" name="magiamgia"
                            value="{{ old('magiamgia', $magiamgia->magiamgia) }}" required>
                        @error('magiamgia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hesogiamgia" class="form-label text-dark">Hệ Số Giảm Giá (%):</label>
                        <input type="number" step="0.01" class="form-control @error('hesogiamgia') is-invalid @enderror" id="hesogiamgia" name="hesogiamgia"
                            value="{{ old('hesogiamgia', $magiamgia->hesogiamgia) }}" required>
                        @error('hesogiamgia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sotientoithieu" class="form-label text-dark">Số Tiền Tối Thiểu (VNĐ):</label>
                        <input type="number" step="1" class="form-control @error('sotientoithieu') is-invalid @enderror" id="sotientoithieu" name="sotientoithieu"
                            value="{{ old('sotientoithieu', $magiamgia->sotientoithieu) }}" required>
                         @error('sotientoithieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     <div class="mb-3">
                        <label for="soluong" class="form-label text-dark">Số Lượng:</label>
                        <input type="number" class="form-control @error('soluong') is-invalid @enderror" id="soluong" name="soluong"
                            value="{{ old('soluong', $magiamgia->soluong) }}" required>
                         @error('soluong')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-3">
                            <label for="thoidiembatdau" class="form-label text-dark">Thời Điểm Bắt Đầu:</label>
                            <input type="datetime-local" class="form-control @error('thoidiembatdau') is-invalid @enderror" id="thoidiembatdau" name="thoidiembatdau"
                                value="{{ old(
                                        'thoidiembatdau',
                                        $magiamgia->thoidiembatdau ? date('Y-m-d\TH:i', strtotime($magiamgia->thoidiembatdau)) : '',
                                    ) }}"
                                required>
                            @error('thoidiembatdau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="thoidiemketthuc" class="form-label text-dark">Thời Điểm Kết Thúc:</label>
                            <input type="datetime-local" class="form-control @error('thoidiemketthuc') is-invalid @enderror" id="thoidiemketthuc" name="thoidiemketthuc"
                                {{-- min="{{ now()->addDay()->format('Y-m-d\TH:i') }}" --}} {{-- Bạn có thể cần điều chỉnh logic min cho trang edit --}}
                                value="{{ old('thoidiemketthuc', isset($magiamgia->thoidiemketthuc) ? date('Y-m-d\TH:i', strtotime($magiamgia->thoidiemketthuc)) : '') }}"
                                required>
                             @error('thoidiemketthuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="trangthai" class="form-label text-dark">Trạng Thái:</label>
                        <select class="form-select @error('trangthai') is-invalid @enderror" id="trangthai" name="trangthai">
                            <option value="0" {{ old('trangthai', $magiamgia->trangthai) == 0 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="1" {{ old('trangthai', $magiamgia->trangthai) == 1 ? 'selected' : '' }}>Ngừng hoạt động</option>
                        </select>
                        @error('trangthai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                             <i class="fas fa-save me-2"></i> Cập nhật
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
