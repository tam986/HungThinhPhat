@extends('page.layout')
@section('title', 'Danh sách danh mục')
@section('content')

    <div class="container-fluid p-1">
        <div class="d-flex d-md-none justify-content-between mb-3 animate__animated animate__fadeInDown">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('danhmucDM.create') }}" class="btn btn-primary">
                <i class="bi bi-plus fs-5"></i> <span class="d-none d-md-inline">Danh mục</span>
            </a>
        </div>

        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-0 animate__animated animate__fadeInDown">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-list-ul text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-dark">Quản lý danh mục</h5>
                    <span class="ml-3 text-muted">
                        Hiện <b class="text-primary">{{ $danhmucs->count() }}</b> trong
                        @if (request('danhmuc') || request('nhacungcap') || request('search') || request('status'))
                            <b class="text-success">{{ $danhmucs->total() }}</b> danh mục được lọc
                        @else
                            tổng <b class="text-success">{{ $danhmucs->total() }}</b> danh mục
                        @endif
                    </span>
                </div>
            </div>
            <div class="container d-none d-md-flex justify-content-end">
                <a href="/danhmuc/create" class="btn btn-primary">
                    <i class="bi bi-plus fs-w-20"></i> Danh mục
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
                                <option value="thutu-asc" {{ request('sort') == 'thutu' ? 'selected' : '' }}>Thứ tự tăng
                                    dần
                                </option>
                                <option value="thutu-desc" {{ request('sort') == 'thutu' ? 'selected' : '' }}>Thứ tự giảm
                                    dần
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group" role="group">
                                <a href="{{ route('danhmucDM.index') }}"
                                    class="btn btn-sm btn-outline-secondary {{ request('anhien') === null ? 'active' : '' }}">Tất
                                    cả</a>
                                <a href="{{ route('danhmucDM.index', array_merge(request()->except('anhien'), ['anhien' => '1'])) }}"
                                    class="btn btn-sm btn-outline-success {{ request('anhien') === '1' ? 'active' : '' }}">Đã
                                    hiện</a>
                                <a href="{{ route('danhmucDM.index', array_merge(request()->except('anhien'), ['anhien' => '0'])) }}"
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
                                <th class="text-center">Tên danh mục</th>
                                <th class="text-center d-none d-md-table-cell">Tổng sản phẩm</th>
                                <th class="text-center d-md-none">Ẩn/Hiện</th>
                                <th class="text-center d-none d-md-table-cell">Ẩn/Hiện</th>
                                <th class="text-center d-none d-md-table-cell">Ngày tạo</th>
                                <th class="text-center d-none d-md-table-cell">Ngày cập nhật</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($danhmucs as $dm)
                                <tr>
                                    <td class="text-center d-none d-md-table-cell">{{ $dm->id }}</td>
                                    <td class="text-center">{{ $dm->thutu }}</td>
                                    <td class="flex-column align-items-start">
                                        <div>{{ $dm->tendanhmuc }}</div>
                                        <small
                                            class="{{ $dm->sanpham_count ? 'text-success' : 'text-secondary' }} d-md-none">
                                            Sản phẩm hiện có: {{ $dm->sanpham_count ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">{{ $dm->sanpham_count }}</td>
                                    <td class="text-center">
                                        @if ($dm->anhien == 0)
                                            <a href="{{ route('danhmucDM.unactive', $dm->id) }}" title="Ẩn danh mục">
                                                <i class="bi bi-eye-fill text-success"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('danhmucDM.active', $dm->id) }}" title="Hiện danh mục">
                                                <i class="bi bi-eye-slash-fill text-danger"></i>
                                            </a>
                                        @endif

                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        {{ $dm->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        {{ $dm->updated_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-none d-md-flex justify-content-center gap-2">
                                            <a href="{{ route('danhmucDM.detail', $dm->id) }}"
                                                class="btn btn-info btn-sm shadow-sm">
                                                <i class="bi bi-three-dots text-white"></i>
                                            </a>
                                            <form action="{{ route('danhmucDM.destroy', $dm->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="return confirm('Xác nhận xóa danh mục?')">
                                                    <i class="bi bi-trash text-white"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-md-none dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle shadow-sm"
                                                type="button" id="dropdownMenuButton{{ $dm->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $dm->id }}">
                                                <li>
                                                    <a class="dropdown-item text-primary"
                                                        href="{{ route('danhmucDM.detail', $dm->id) }}">
                                                        <i class="bi bi-three-dots"></i> Chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('danhmucDM.destroy', $dm->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Xác nhận xóa danh mục?')">
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
                                    <td colspan="8" class="text-center">Không có danh mục cần tìm.</td>
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
                            @if ($danhmucs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $danhmucs->url(1) }}" title="Về đầu trang">«</a>
                                </li>
                            @endif
                            @if ($danhmucs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $danhmucs->previousPageUrl() }}">Prev</a></li>
                            @endif
                            @foreach ($danhmucs->links()->elements[0] as $page => $url)
                                @if ($page == $danhmucs->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($danhmucs->hasMorePages())
                                <li class="page-item"><a class="page-link"
                                        href="{{ $danhmucs->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                            @if ($danhmucs->onLastPage())
                                <li class="page-item disabled"><span class="page-link">»</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $danhmucs->url($danhmucs->lastPage()) }}"
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
