@extends('page.layout')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-dark">Sửa danh mục</h1>
        <form action="{{ route('danhmuc.update', $danhmuc->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3 ">
                <label for="tendm" class="form-label text-dark">Tên danh mục:</label>
                <input type="text" name="tendm" class="form-control" value="{{ $danhmuc->tendm }}" required>
            </div>
            <div class="mb-3">
                <label for="thutu" class="form-label text-dark">Thứ tự:</label>
                <input type="number" name="thutu" class="form-control" value="{{ $danhmuc->thutu }}">
            </div>
            <div class="mb-3">
                <label for="anhien" class="form-label text-dark">Ẩn/Hiện:</label>
                <select name="anhien" class="form-control">
                    <option value="1" {{ $danhmuc->anhien ? 'selected' : '' }}>Hiện</option>
                    <option value="0" {{ !$danhmuc->anhien ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>
@endsection
