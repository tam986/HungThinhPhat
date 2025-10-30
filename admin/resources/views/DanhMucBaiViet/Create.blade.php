@extends('page.layout')
@section('content')
    <div class="container mt-4 text-dark">
        <h1 class="mb-4 text-dark">Thêm danh mục</h1>
        <form action="{{ route('danhmuc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="tendm" class="form-label">Tên danh mục:</label>
                <input type="text" name="tendm" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="thutu" class="form-label">Thứ tự:</label>
                <input type="text" name="thutu" class="form-control">
            </div>
            <div class="mb-3">
                <label for="anhien" class="form-label">Ẩn/Hiện:</label>
                <select name="anhien" class="form-control">
                    <option value="1">Hiện</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Lưu</button>
        </form>
    </div>
@endsection
