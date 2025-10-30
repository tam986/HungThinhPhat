@extends('page.layout')
@section('title', 'Quản lý người dùng')
@section('content')
    <div class="container-fluid  p-5">
        <button type="button" class="btn btn-secondary me-2 mb-4">
            < Trở lại</button>
                <div class="container bg-white shadow-sm rounded d-flex align-items-center mb-4 p-0">
                    <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
                        <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
                        <div>
                            <h5 class="text-dark">Quản lý danh mục bài viết</h5>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-end">
                        <a href=" {{ route('danhmuc.create') }}" class="btn btn-primary"> <span><i
                                    class="bi bi-plus fs-w-20"></i>Danh
                                mục</span> </a>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card bg-white shadow-sm border-0 text-white mb-4">
                        <div class="card-body">
                            <table class="table table-hover table-white">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên danh mục</th>
                                        <th scope="col">Thứ tự</th>
                                        <th scope="col">Ẩn / hiện</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($danhmucs as $dmbaiviet)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $dmbaiviet->tendm }}</td>
                                            <td>{{ $dmbaiviet->thutu }}</td>
                                            @if ($dmbaiviet->anhien == 0)
                                                <td>Ẩn</td>
                                            @else
                                                <td>Hiện</td>
                                            @endif
                                            <td>

                                                <a href="{{ route('user.detail', $dmbaiviet->id) }}"
                                                    class="btn btn-info btn-sm">Chi tiết</a>
                                                <a href="{{ route('danhmuc.edit', $dmbaiviet->id) }}"
                                                    class="btn btn-warning btn-sm">Sửa</a>
                                                <form action="{{ route('user.destroy', $dmbaiviet->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">Xóa
                                                        </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- end user chính --}}
    </div>

@endsection
