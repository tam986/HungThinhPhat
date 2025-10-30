@extends('page.layout')
@section('title', 'Chi tiết danh mục')
@section('content')
    <div class="container-fluid p-5">
        <a href="{{ route('danhmucDM.index') }}" class="btn btn-secondary me-2 animate__animated animate__fadeInRight">
            <i class="bi bi-arrow-left"></i> Trở lại
        </a>

        <div
            class="container d-flex bg-white shadow-sm rounded align-items-center mt-4 mb-4 p-0 animate__animated animate__fadeInDown">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-list-ul text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-black">Chi tiết danh mục</h5>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4 animate__animated animate__fadeInUp">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="text-center p-5 bg-light rounded">
                            <i class="bi bi-bookmark fs-1 text-muted"></i>
                            <p class="text-muted">Danh mục không có hình ảnh</p>
                        </div>
                        <p class="text-muted text-center">{{ $danhmuc->mota ?? 'Không có mô tả' }}</p>
                    </div>

                    <div class="col-md-7 mb-3">
                        <h4 class="mb-3">{{ $danhmuc->tendanhmuc }}</h4>
                        <dl class="row">
                            <dt class="col-sm-4">Số lượng sản phẩm:</dt>
                            <dd class="col-sm-8">{{ $danhmuc->sanpham_count ?? 0 }}</dd>

                            <dt class="col-sm-4">Trạng thái danh mục:</dt>
                            <dd class="col-sm-8">
                                {{ $danhmuc->anhien == 1 ? 'Hiện' : 'Ẩn' }}
                            </dd>

                            <dt class="col-sm-4">Thứ tự danh mục:</dt>
                            <dd class="col-sm-8">{{ $danhmuc->thutu ?? 'Không có thứ tự' }}</dd>

                            <dt class="col-sm-4">Ngày tạo:</dt>
                            <dd class="col-sm-8">{{ $danhmuc->created_at->format('d/m/Y H:i:s') }}</dd>

                            <dt class="col-sm-4">Ngày cập nhật:</dt>
                            <dd class="col-sm-8">{{ $danhmuc->updated_at->format('d/m/Y H:i:s') }}</dd>
                        </dl>
                        <div class="d-flex justify-content-start gap-2 mt-4">
                            <a href="{{ route('danhmucDM.edit', $danhmuc->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Chỉnh sửa
                            </a>
                            <form action="{{ route('danhmucDM.destroy', $danhmuc->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Xác nhận xóa danh mục?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .form-control {
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary,
        .btn-secondary,
        .btn-danger {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }

            .col-md-5,
            .col-md-7 {
                width: 100%;
            }
        }
    </style>
@endsection
