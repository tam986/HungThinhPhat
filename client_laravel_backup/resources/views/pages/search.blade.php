@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('content')
    <h2>Không tìm thấy kết quả nào cho: "{{ $kyw }}"</h2>
    <p>Vui lòng thử lại với từ khóa khác.</p>
@endsection
