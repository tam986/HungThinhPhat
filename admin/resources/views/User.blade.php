@extends('page.layout')
@section('title', 'Dashboard')
@section('subtitle', 'Quản lý người dùng')
@section('content')
    <div class="container-fluid  p-1 animate__animated animate__fadeInRight">
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
            &lt; Trở lại
        </a>

        <div class="container d-flex bg-white shadow-sm rounded align-items-center mt-4 mb-4 p-0">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-dark">Quản lý người dùng</h5>
                    <span class="ml-3 text-muted text-end">
                        Hiện <b class="text-primary">{{ $users->count() }}</b> trong
                        tổng <b class="text-success">{{ $users->total() }}</b> người dùng
                    </span>
                </div>
            </div>
            <div class="container d-flex justify-content-end">
                <a href=" /user/create" class="btn btn-primary"> <span><i class="bi bi-plus fs-w-20"></i>Tài
                        khoản</span> </a>
            </div>
        </div>
        <h5 class="btn btn-success border-0">Danh sách user</h5>
      

        <div class="card bg-white shadow-sm border-0 text-dark mb-4">
            <div class="card-header bg-white border-0 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-4 align-items-center">
                        <form action="" method="GET" class="input-group w-auto mr-3">
                            <input type="text" name="search" class="form-control bg-white text-black"
                                placeholder="Tìm kiếm..." value="{{ request('search') }}">
                            <button class="btn btn-outline-dark border-0 shadow-sm" type="submit"><i
                                    class="fas fa-search"></i></button>
                        </form>
                        <form action="" method="GET" class="d-inline">
                            <select name="sort" class="form-control bg-white d-inline-block text-dark w-auto"
                                onchange="this.form.submit()">
                                <option value="" class="text-center">--- Sắp xếp ---</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                    Mới nhất</option>
                                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Tên
                                    A-Z</option>
                                <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Tên
                                    Z-A</option>
                            </select>
                        </form>

                        <form action="" method="GET" class="d-inline">
                            <select name="role" class="form-control bg-white d-inline-block text-dark w-auto"
                                onchange="this.form.submit()">
                                <option value="" class="text-center">--- Vai trò ---</option>
                                <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>
                                    Customer</option>
                            </select>
                        </form>

                    </div>
                </div>
            </div>
            <div class="card-body bg-light border-0">
                <table id="isDeskTop" class="table table-hover table-light w-100">
                    <thead>
                        <tr class="text-center">
                            <th class="col-1">STT</th>
                            <th class="col-3">Tên người dùng</th>
                            <th class="col-3">Email</th>
                            <th class="col-2  d-none d-md-table-cell">Vai trò</th>
                            <th class="col-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="text-center">
                                <td>{{ $user->id }}</td>
                                <td
                                    style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $user->hoten }}
                                </td>
                                <td
                                    style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $user->email }}
                                </td>
                                <td class=" d-none d-md-table-cell">

                                    <form action="{{ route('user.updateRole', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if (Auth::user()->id == $user->id)
                                            <select name="quyen" class="form-control text-center"
                                                onchange="this.form.submit()" disabled>
                                                <option value="0" {{ $user->quyen == 0 ? 'selected' : '' }}>
                                                    Customer</option>
                                                <option value="1" {{ $user->quyen == 1 ? 'selected' : '' }}>
                                                    Admin</option>
                                            </select>
                                        @else
                                            <select name="quyen" class="form-control text-center"
                                                onchange="this.form.submit()">
                                                <option value="0" {{ $user->quyen == 0 ? 'selected' : '' }}>
                                                    Customer</option>
                                                <option value="1" {{ $user->quyen == 1 ? 'selected' : '' }}>
                                                    Admin</option>
                                            </select>
                                        @endif
                                    </form>
                                </td>

                                <td class="col-2 col-md-2">
                                    {{-- Hành động desktop --}}
                                    <div class="d-none d-md-flex justify-content-center gap-2">
                                        <a href="{{ route('user.detail', $user->id) }}"
                                            class="btn btn-info d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-three-dots fs-5"></i>
                                        </a>

                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-warning d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-eraser fs-5"></i>
                                        </a>

                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Xác nhận xóa người dùng?')"
                                                class="btn btn-danger d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- hành động mobile --}}
                                    <div class="d-md-none dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                            <li>
                                                <a class="dropdown-item text-primary"
                                                    href="{{ route('user.detail', $user->id) }}">
                                                    <i class="bi bi-three-dots"></i> Chi tiết
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-warning"
                                                    href="{{ route('user.edit', $user->id) }}">
                                                    <i class="bi bi-eraser"></i> Sửa
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-sm btn-danger text-danger"
                                                        onclick="return confirm('Xác nhận xóa vĩnh viễn user này?')">
                                                        <i class="bi bi-shield-x fs-4"></i> Xóa
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <span class="p-4">Vai trò:</span>
                                                <form action="{{ route('user.updateRole', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="quyen"
                                                        class="form-control text-center dropdown-item border border-success "
                                                        onchange="this.form.submit()">
                                                        <option class="d-block" value="0"
                                                            {{ $user->quyen == 0 ? 'selected' : '' }}>
                                                            Customer</option>
                                                        <option value="1" {{ $user->quyen == 1 ? 'selected' : '' }}>
                                                            Admin</option>
                                                    </select>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="card-footer bg-white border 0 shadow-sm">
                <div class="d-flex justify-content-center mt-3">
                    <nav>
                        <ul class="pagination">
                            @if ($users->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">«</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">«</a>
                                </li>
                            @endif
                            @foreach ($users->links()->elements[0] as $page => $url)
                                @if ($page == $users->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                            @if ($users->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">»</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">»</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    @media (max-width: 768px) {
        .dropdown-menu {
            min-width: 100px;
        }
    }
</style>
