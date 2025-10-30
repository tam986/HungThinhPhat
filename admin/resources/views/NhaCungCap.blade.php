@extends('page.layout')
@section('title', 'Danh sách nhà cung cấp')
@section('content')
    <div class="container-fluid p-1">
        <div class="d-flex d-md-none justify-content-between mb-3 animate__animated animate__fadeInDown">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('nhacungcap.create') }}" class="btn btn-primary">
                <i class="bi bi-plus fs-5"></i> <span class="d-none d-md-inline">Nhà cung cấp</span>
            </a>
        </div>

        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-0 animate__animated animate__fadeInDown">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-truck text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-dark">Quản lý nhà cung cấp</h5>
                    <span class="ml-3 text-muted">
                        Hiện <b class="text-primary">{{ $nhacungcaps->count() }}</b> trong
                        @if (request('search') || request('sort') || request('thutu') || request('anhien'))
                            <b class="text-success">{{ $nhacungcaps->total() }}</b> nhà cung cấp được lọc
                        @else
                            tổng <b class="text-success">{{ $nhacungcaps->total() }}</b> nhà cung cấp
                        @endif
                    </span>
                </div>
            </div>
            <div class="container d-none d-md-flex justify-content-end">
                <a href="{{ route('nhacungcap.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus fs-w-20"></i> Nhà cung cấp
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded animate__animated animate__shakeX"
                role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded animate__animated animate__shakeX"
                role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-2 animate__animated animate__fadeIn">
            <a href="{{ route('danhmucDM.index') }}"
                class="btn btn-primary {{ request()->routeIs('danhmucDM.index') ? 'btn-primary shadow-inner' : '' }}">Danh
                mục</a>
            <a href="{{ route('nhacungcap.index') }}"
                class="btn btn-warning  {{ request()->routeIs('nhacungcap.index') ? 'btn-primary shadow-inner' : '' }}">Nhà
                cung cấp</a>
        </div>

        <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeIn">
            <div class="card-header border-0 p-3">
                <form action="" method="GET" class="rounded">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="Tìm kiếm..." value="{{ request('search') }}">
                                <button class="btn btn-dark" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="sort" class="form-select shadow-sm" onchange="this.form.submit()">
                                <option value="">Sắp xếp</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất
                                </option>
                                <option value="thutu-asc" {{ request('sort') == 'thutu-asc' ? 'selected' : '' }}>Thứ tự
                                    tăng dần</option>
                                <option value="thutu-desc" {{ request('sort') == 'thutu-desc' ? 'selected' : '' }}>Thứ tự
                                    giảm dần</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group" role="group">
                                <a href="{{ route('nhacungcap.index') }}"
                                    class="btn btn-sm btn-outline-secondary {{ request('anhien') === null ? 'active' : '' }}">Tất
                                    cả</a>
                                <a href="{{ route('nhacungcap.index', array_merge(request()->except('anhien'), ['anhien' => '1'])) }}"
                                    class="btn btn-sm btn-outline-success {{ request('anhien') === '1' ? 'active' : '' }}">Đã
                                    hiện</a>
                                <a href="{{ route('nhacungcap.index', array_merge(request()->except('anhien'), ['anhien' => '0'])) }}"
                                    class="btn btn-sm btn-outline-danger {{ request('anhien') === '0' ? 'active' : '' }}">Đã
                                    ẩn</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center d-none d-md-table-cell">ID</th>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên nhà cung cấp</th>
                                <th class="text-center d-none d-md-table-cell">Hình ảnh</th>
                                <th class="text-center d-none d-md-table-cell">Tổng sản phẩm</th>
                                <th class="text-center d-md-none">Ẩn/Hiện</th>
                                <th class="text-center d-none d-md-table-cell">Ẩn/Hiện</th>
                                <th class="text-center d-none d-md-table-cell">Ngày tạo</th>
                                <th class="text-center d-none d-md-table-cell">Ngày cập nhật</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($nhacungcaps as $ncc)
                                <tr>
                                    <td class="text-center d-none d-md-table-cell">{{ $ncc->id }}</td>
                                    <td class="text-center">{{ $ncc->thutu }}</td>
                                    <td class="flex-column align-items-start">
                                        <div>{{ $ncc->tennhacungcap }}</div>
                                        <small
                                            class="{{ $ncc->sanpham_count ? 'text-success' : 'text-secondary' }} d-md-none">
                                            Sản phẩm hiện có: {{ $ncc->sanpham_count ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        @if ($ncc->hinhanh)
                                            <img src="{{ asset('storage/' . $ncc->hinhanh) }}"
                                                alt="{{ $ncc->tennhacungcap }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                        @else
                                            <i class="bi bi-image text-muted"></i>
                                        @endif
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">{{ $ncc->sanpham_count }}</td>
                                    <td class="text-center">
                                        @if ($ncc->anhien == 0)
                                            <a href="{{ route('nhacungcap.unactive', $ncc->id) }}">
                                                <i class="bi bi-eye-slash-fill text-danger"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('nhacungcap.active', $ncc->id) }}">
                                                <i class="bi bi-eye-fill text-success"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        {{ $ncc->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        {{ $ncc->updated_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-none d-md-flex justify-content-center gap-2">
                                            <a href="{{ route('nhacungcap.detail', $ncc->id) }}"
                                                class="btn btn-info btn-sm shadow-sm">
                                                <i class="bi bi-three-dots text-white"></i>
                                            </a>
                                            <form action="{{ route('nhacungcap.destroy', $ncc->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="return confirm('Xác nhận xóa nhà cung cấp?')">
                                                    <i class="bi bi-trash text-white"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-md-none dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle shadow-sm"
                                                type="button" id="dropdownMenuButton{{ $ncc->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $ncc->id }}">
                                                <li>
                                                    <a class="dropdown-item text-primary"
                                                        href="{{ route('nhacungcap.detail', $ncc->id) }}">
                                                        <i class="bi bi-three-dots"></i> Chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('nhacungcap.destroy', $ncc->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Xác nhận xóa nhà cung cấp?')">
                                                            <i class="bi bi-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Không có nhà cung cấp cần tìm.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer border-0 py-3">
                <div class="d-flex justify-content-center">
                    <nav>
                        <ul class="pagination shadow-sm">
                            @if ($nhacungcaps->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $nhacungcaps->url(1) }}" title="Về đầu trang">«</a>
                                </li>
                            @endif
                            @if ($nhacungcaps->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $nhacungcaps->previousPageUrl() }}">Prev</a></li>
                            @endif
                            @foreach ($nhacungcaps->links()->elements[0] as $page => $url)
                                @if ($page == $nhacungcaps->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($nhacungcaps->hasMorePages())
                                <li class="page-item"><a class="page-link"
                                        href="{{ $nhacungcaps->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                            @if ($nhacungcaps->onLastPage())
                                <li class="page-item disabled"><span class="page-link">»</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $nhacungcaps->url($nhacungcaps->lastPage()) }}"
                                        title="Về cuối trang">»</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }


        div a.btn.shadow-inner {
            box-shadow: inset 3px 3px 8px rgba(0, 0, 0, 0.3), inset -3px -3px 8px rgba(255, 255, 255, 0.3) !important;

        }

        @media (max-width: 768px) {
            .dropdown-menu {
                min-width: 100px;
            }
        }
    </style>
@endsection
