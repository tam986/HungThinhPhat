@extends('page.layout')
@section('title', 'Quản lý xóa mềm')
@section('content')
    <div class="container-fluid p-1">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-0 animate__animated animate__fadeIn">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-dark">Quản lý thùng rác</h5>
                    <span class="ml-3 text-muted text-end">
                        Hiện <b class="text-primary">{{ $trashedSanphams->count() }}</b> trong
                        @if (request('danhmuc') || request('nhacungcap') || request('search') || request('status'))
                            <b class="text-danger">{{ $trashedSanphams->total() }}</b> sản phẩm được lọc
                        @else
                            <b class="text-danger">{{ $trashedSanphams->total() }}</b> sản phẩm đã xóa
                        @endif
                    </span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded animate__animated animate__bounceIn"
                role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded animate__animated animate__bounceIn"
                role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="animate__animated animate__fadeIn">
            <a href="{{ route('sanpham.index') }}" class="btn btn-primary">Sản phẩm</a>
            <a href="{{ route('sanpham.trashed') }}" class="btn btn-warning shadow-inner">Thùng rác</a>
        </div>

        <div class="card border-0 shadow bg-white text-dark mb-4 animate__animated animate__fadeIn">
            <div class="card-header border-0">
                <form action="" method="GET" class="p-3 rounded">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-dark" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 col-md-2">
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="">Sắp xếp</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sản phẩm
                                    mới nhất</option>
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Tên:
                                    A-Z</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>
                                    Tên: Z-A</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-2">
                            <select name="danhmuc" class="form-select" onchange="this.form.submit()">
                                <option value="">Danh mục</option>
                                @foreach ($danhmucs as $dm)
                                    <option value="{{ $dm->id }}"
                                        {{ request('danhmuc') == $dm->id ? 'selected' : '' }}>
                                        {{ $dm->tendanhmuc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-2">
                            <select name="nhacungcap" class="form-select" onchange="this.form.submit()">
                                <option value="">Nhà cung cấp</option>
                                @foreach ($nhacungcaps as $ncc)
                                    <option value="{{ $ncc->id }}"
                                        {{ request('nhacungcap') == $ncc->id ? 'selected' : '' }}>
                                        {{ $ncc->tennhacungcap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body border-0">
                <table class="table table-white table-hover w-100">
                    <thead>
                        <tr>
                            <th class="text-center d-none d-md-table-cell col-md-1">ID</th>
                            <th class="text-center col-4 col-md-4">Sản phẩm</th>
                            <th class="text-center d-md-none col-6">Danh mục<br>Nhà cung cấp</th>
                            <th class="text-center d-none d-md-table-cell col-md-2">Danh mục</th>
                            <th class="text-center d-none d-md-table-cell col-md-2">Nhà cung cấp</th>

                            <th class="text-center col-2 col-md-2">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trashedSanphams as $tsp)
                            <tr>
                                <td class="text-center d-none d-md-table-cell col-md-1">{{ $tsp->id }}</td>
                                <td class="col-4 col-md-4">
                                    <div class="d-flex align-items-center">
                                        <span class="fst-italic d-md-none"><strong>{{ $tsp->id }}</strong>.</span>
                                        <img src="{{ asset('storage/' . $tsp->bienthe->first()->hinh) }}" width="50px" height="50px"
                                            alt="{{ $tsp->tensp }}">
                                        <div class="flex-column align-items-start ms-2">
                                            <h6>{{ $tsp->tensp }}</h6>
                                            <span class="{{ $tsp->total_soluong ? 'text-success' : 'text-secondary' }}">
                                                Có {{ $tsp->total_soluong ?? 0 }} sản phẩm
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-md-none col-6">
                                    {{ $tsp->danhmuc ? $tsp->danhmuc->tendanhmuc : 'Chưa có danh mục' }}
                                    <hr>
                                    {{ $tsp->nhacungcap->tennhacungcap ?? $tsp->id_nhacungcap }}
                                </td>
                                <td class="d-none d-md-table-cell col-md-2">
                                    {{ $tsp->danhmuc ? $tsp->danhmuc->tendanhmuc : 'Chưa có danh mục' }}
                                </td>
                                <td class="d-none d-md-table-cell col-md-2">
                                    {{ $tsp->nhacungcap->tennhacungcap ?? $tsp->id_nhacungcap }}
                                </td>

                                <td class="col-2 col-md-2">
                                    <div class="d-none d-md-flex justify-content-center gap-2">
                                        <form action="{{ route('sanpham.restore', $tsp->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                onclick="return confirm('Khôi phục sản phẩm?')">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('sanpham.destroy', $tsp->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Xác nhận xóa vĩnh viễn sản phẩm này?')">
                                                <i class="bi bi-shield-x"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="d-md-none dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $tsp->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $tsp->id }}">
                                            <li>
                                                <form action="{{ route('sanpham.restore', $tsp->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success"
                                                        onclick="return confirm('Khôi phục sản phẩm?')">
                                                        <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('sanpham.destroy', $tsp->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Xác nhận xóa vĩnh viễn sản phẩm này?')">
                                                        <i class="bi bi-shield-x"></i> Xóa vĩnh viễn
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <span
                                                    class="form-control text-center {{ $tsp->trangthai == 'mới' ? 'bg-success text-white' : 'bg-warning text-dark' }}"
                                                    style="pointer-events: none;">
                                                    {{ $tsp->trangthai }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có sản phẩm cần tìm.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer border-0 py-3">
                <div class="d-flex justify-content-center">
                    <nav>
                        <ul class="pagination shadow-sm">
                            @if ($trashedSanphams->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $trashedSanphams->url(1) }}"
                                        title="Về đầu trang">«</a>
                                </li>
                            @endif
                            @if ($trashedSanphams->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $trashedSanphams->previousPageUrl() }}">Prev</a></li>
                            @endif
                            @foreach ($trashedSanphams->links()->elements[0] as $page => $url)
                                @if ($page == $trashedSanphams->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($trashedSanphams->hasMorePages())
                                <li class="page-item"><a class="page-link"
                                        href="{{ $trashedSanphams->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                            @if ($trashedSanphams->onLastPage())
                                <li class="page-item disabled"><span class="page-link">»</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $trashedSanphams->url($trashedSanphams->lastPage()) }}"
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
        .status-circle {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        div a.btn.shadow-inner {
            box-shadow: inset 3px 3px 8px rgba(0, 0, 0, 0.3),
                inset -3px -3px 8px rgba(255, 255, 255, 0.3) !important;
        }

        @media (max-width: 768px) {
            .dropdown-menu {
                min-width: 100px;
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
