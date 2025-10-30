@extends('page.layout')

@section('content')
    <div class="container mt-4">
        <h4 style=color:black>Thùng rác - Bài viết đã xóa</h4>
        <a href="{{ route('baiviet.index') }}" class="btn btn-outline-primary mb-3">Danh sách bài viết</a>
        <a href="{{ route('baiviet.trashed') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-trash"></i> Thùng rác
        </a>
        <table class="table table-hover table-light">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deletedPost as $deleted)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $deleted->tieude }}</td>
                        <td>{{ $deleted->motangan }}</td>
                        <td>
                            <form action="{{ route('baiviet.restore', $deleted->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn khôi phục bài viết này?')">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            </form>
                            <form action="{{ route('baiviet.delete', $deleted->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn bài viết này? Hành động này không thể hoàn tác.')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Không có bài viết nào trong thùng rác.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
