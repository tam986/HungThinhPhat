@extends('page.layout')
@section('title', 'Cập nhật nhân bánh')
@section('content')
    <div class="container-fluid p-3 p-md-3">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-cake-fill text-danger bg-light p-4 rounded fs-4"></i>
                <div>
                    <h4 class="text-dark mb-0 fw-bold">Cập nhật nhân bánh</h4>
                    <small class="text-muted">ID: {{ $nhanbanh->id }} - {{ $nhanbanh->tenNhanBanh }}</small>
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
                <form method="POST" action="{{ route('nhanbanh.update', $nhanbanh->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="tenNhanBanh" class="form-label fw-semibold">Nhân bánh</label>
                                <input type="text"
                                    class="form-control form-control-lg shadow-sm @error('tenNhanBanh') is-invalid @enderror"
                                    id="tenNhanBanh" name="tenNhanBanh"
                                    value="{{ old('tenNhanBanh', $nhanbanh->tenNhanBanh) }}" required>
                                @error('tenNhanBanh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-end gap-2 mt-4">
                        <a href="{{ route('nhanbanh.index') }}" class="btn btn-outline-secondary w-100 w-md-auto shadow-sm">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary w-100 w-md-auto shadow-sm">
                            <i class="bi bi-save"></i> Cập nhật nhân bánh
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
