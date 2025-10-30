@extends('page.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Quản lý bình luận')
@section('content')
    <div class="container-fluid  p-1 animate__animated animate__fadeInRight">
        <div class="container d-flex bg-white shadow-sm rounded align-items-center mt-4 mb-4 p-0">
            <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                <div>
                    <h5 class="text-dark">Quản lý bình luận</h5>
                    <span class="ml-3 text-muted text-end">
                        Hiện <b class="text-primary">{{ $comments->count() }}</b> trong
                        tổng <b class="text-success">{{ $comments->total() }}</b> bình luận
                    </span>
                </div>
            </div>
        </div>
        <div class="container">
            <h2 class="mb-4 text-dark">Quản lý Bình Luận</h2>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover table-white">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Người dùng</th>
                        <th>Sản phẩm</th>
                        <th>Ẩn / hiện</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $binhLuan)
                        <tr>
                            <td>{{ $binhLuan->id }}</td>
                            <td>{{ $binhLuan->noidung }}</td>
                            <td>{{ $binhLuan->user->hoten ?? 'Không xác định' }}</td>
                            <td>{{ $binhLuan->id_bienthe }}</td>
                            <td>{{ $binhLuan->trangthai == 'đã duyệt' ? 'đã duyệt' : 'chờ duyệt' }}</td>
                            <td class="text-center">
                                @if ($binhLuan->anhien == 0)
                                    <form action="{{ route('binhluan.active', $binhLuan->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn hiện bình luận?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-link p-0" title="Hiện bình luận">
                                            <i class="bi bi-eye-slash-fill text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('binhluan.unactive', $binhLuan->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn ẩn bình luận?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-link p-0" title="Ẩn bình luận">
                                            <i class="bi bi-eye-fill text-success"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($binhLuan->trangthai == 'chờ duyệt')
                                    <form action="{{ route('binhluan.duyet', $binhLuan->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="width:120px;">Duyệt</button>
                                    </form>
                                @endif

                                <form action="{{ route('binhluan.an', $binhLuan->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn ẩn?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger" style="width:120px;">Từ chối</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có bình luận nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
