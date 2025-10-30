@extends('page.layout')
@section('title', 'Danh sách nhân bánh')
@section('content')
    <div class="container-fluid p-1">
        <div class="d-flex d-md-none justify-content-between mb-3 animate__animated animate__fadeInDown">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('nhanbanh.create') }}" class="btn btn-primary">
                <i class="bi bi-plus fs-5"></i> <span class="d-none d-md-inline">Nhân bánh</span>
            </a>
        </div>

        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-0 animate__animated animate__fadeInDown">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-cake-fill text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-dark">Quản lý nhân bánh</h5>
                    <span class="ml-3 text-muted">
                        Hiện <b class="text-primary">{{ $nhanbanhs->count() }}</b> trong
                        @if (request('search') || request('sort'))
                            <b class="text-success">{{ $nhanbanhs->total() }}</b> nhân bánh được lọc
                        @else
                            tổng <b class="text-success">{{ $nhanbanhs->total() }}</b> nhân bánh
                        @endif
                    </span>
                </div>
            </div>
            <div class="container d-none d-md-flex justify-content-end">
                <a href="{{ route('nhanbanh.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus fs-w-20"></i> Nhân bánh
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

        <div class="mb-3 animate__animated animate__fadeIn">
            {{-- <a href="{{ route('danhmucDM.index') }}"
                class="btn btn-white {{ request()->routeIs('danhmucDM.index') ? 'shadow-inner' : '' }}">Danh mục</a>
            <a href="{{ route('nhacungcap.index') }}"
                class="btn btn-white {{ request()->routeIs('nhacungcap.index') ? 'shadow-inner' : '' }}">Nhà cung cấp</a> --}}
            <a href="{{ route('khoiluong.index') }}"
                class="btn btn-white {{ request()->routeIs('khoiluong.index') ? 'shadow-inner' : '' }}">Khối lượng</a>
            <a href="{{ route('nhanbanh.index') }}"
                class="btn btn-white {{ request()->routeIs('nhanbanh.index') ? 'shadow-inner' : '' }}">Nhân bánh</a>
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
                            </select>
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
                                <th class="text-center">Nhân bánh</th>
                                <th class="text-center d-none d-md-table-cell">Tổng biến thể</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($nhanbanhs as $nb)
                                <tr>
                                    <td class="text-center d-none d-md-table-cell">{{ $nb->id }}</td>
                                    <td class="flex-column align-items-start">
                                        <div>{{ $nb->tenNhanBanh }}</div>
                                        <small
                                            class="{{ $nb->bienthe_count ? 'text-success' : 'text-secondary' }} d-md-none">
                                            Số biến thể: {{ $nb->bienthe_count ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">{{ $nb->bienthe_count }}</td>
                                    <td class="text-center">
                                        <div class="d-none d-md-flex justify-content-center gap-2">
                                            <a href="{{ route('nhanbanh.edit', $nb->id) }}"
                                                class="btn btn-warning btn-sm shadow-sm">
                                                <i class="bi bi-eraser text-white"></i>
                                            </a>
                                            <form action="{{ route('nhanbanh.destroy', $nb->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="return confirm('Xác nhận xóa nhân bánh?')">
                                                    <i class="bi bi-trash text-white"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-md-none dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle shadow-sm"
                                                type="button" id="dropdownMenuButton{{ $nb->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $nb->id }}">
                                                <li>
                                                    <a class="dropdown-item text-warning"
                                                        href="{{ route('nhanbanh.edit', $nb->id) }}">
                                                        <i class="bi bi-eraser"></i> Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('nhanbanh.destroy', $nb->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Xác nhận xóa nhân bánh?')">
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
                                    <td colspan="5" class="text-center">Không có nhân bánh cần tìm.</td>
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
                            @if ($nhanbanhs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $nhanbanhs->url(1) }}" title="Về đầu trang">«</a>
                                </li>
                            @endif
                            @if ($nhanbanhs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $nhanbanhs->previousPageUrl() }}">Prev</a></li>
                            @endif
                            @foreach ($nhanbanhs->links()->elements[0] as $page => $url)
                                @if ($page == $nhanbanhs->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($nhanbanhs->hasMorePages())
                                <li class="page-item"><a class="page-link"
                                        href="{{ $nhanbanhs->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                            @if ($nhanbanhs->onLastPage())
                                <li class="page-item disabled"><span class="page-link">»</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $nhanbanhs->url($nhanbanhs->lastPage()) }}"
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
