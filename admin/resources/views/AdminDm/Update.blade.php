@extends('page.layout')
@section('title', 'Cập nhật danh mục')
@section('content')
    <div class="container-fluid p-3 p-md-3">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-list-ul text-danger bg-light p-4 rounded fs-4"></i>
                <div>
                    <h4 class="text-dark mb-0 fw-bold">Cập nhật danh mục</h4>
                    <small class="text-muted">ID: {{ $danhmuc->id }} - {{ $danhmuc->tendanhmuc }}</small>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded animate__animated animate__shakeX"
                role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('danhmucDM.update', $danhmuc->id) }}" id="updateDanhmucForm">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="tendanhmuc" class="form-label fw-semibold">Tên danh mục</label>
                                <input type="text"
                                    class="form-control form-control-lg shadow-sm @error('tendanhmuc') is-invalid @enderror"
                                    id="tendanhmuc" name="tendanhmuc" value="{{ old('tendanhmuc', $danhmuc->tendanhmuc) }}"
                                    required>
                                @error('tendanhmuc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mota" class="form-label fw-semibold">Mô tả</label>
                                <textarea class="form-control form-control-lg shadow-sm @error('mota') is-invalid @enderror" id="mota"
                                    name="mota" rows="3">{{ old('mota', $danhmuc->mota) }}</textarea>
                                @error('mota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="thutu" class="form-label fw-semibold">Thứ tự</label>
                                <input type="number"
                                    class="form-control form-control-lg shadow-sm @error('thutu') is-invalid @enderror"
                                    id="thutu" name="thutu" value="{{ old('thutu', $danhmuc->thutu) }}" min="0"
                                    required>
                                @error('thutu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="anhien" class="form-label fw-semibold">Ẩn/Hiện</label>
                                <select class="form-control form-control-lg shadow-sm @error('anhien') is-invalid @enderror"
                                    id="anhien" name="anhien" required>
                                    <option value="1" {{ old('anhien', $danhmuc->anhien) == 1 ? 'selected' : '' }}>
                                        Hiện</option>
                                    <option value="0" {{ old('anhien', $danhmuc->anhien) == 0 ? 'selected' : '' }}>Ẩn
                                    </option>
                                </select>
                                @error('anhien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-end gap-2 mt-4">
                        <a href="{{ route('danhmucDM.detail', $danhmuc->id) }}"
                            class="btn btn-outline-secondary w-100 w-md-auto shadow-sm">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary w-100 w-md-auto shadow-sm">
                            <i class="bi bi-save"></i> Cập nhật danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('updateFormDM').addEventListener('submit', function(event) {
            event.preventDefault();

            const thutu = document.getElementById('thutu').value;

            fetch('{{ route('danhmucDM.checkthutu') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        thutu: thutu
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        if (confirm(
                                'Thứ tự đang được gán cho danh mục khác, xác nhận thay đổi?'
                            )) {
                            event.target.submit();
                        }
                    } else {
                        event.target.submit();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi kiểm tra thứ tự. Vui lòng thử lại.');
                });
        });
    </script>
@endsection

@section('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border-radius: 15px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-control,
        .btn {
            border-radius: 10px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00b4db);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #0098b8);
        }

        .btn-outline-secondary {
            border-color: #6c757d;
        }
    </style>
@endsection
