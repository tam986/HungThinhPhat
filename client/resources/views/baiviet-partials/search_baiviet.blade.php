{{-- @extends('layouts.layout')
@section('content')
    <div class="container baiviet-container my-4">
        <div class="row">
            <div class="col-md-9">
                <div class="baiviet-search-result bg-white shadow-sm rounded p-3">
                    <form action="{{ route('baiviet.search') }}" method="GET" class="baiviet-search-form d-flex gap-2 mb-3">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm bài viết..."
                            class="form-control w-50">
                        <button type="submit" class="btn btn-primary">Tìm</button>
                    </form>

                    <h4 class="fw-bold">Kết quả tìm kiếm / lọc</h4>
                    <div class="row baiviet-post-list">
                        @if ($baiviet->isEmpty())
                            <p>Không có bài viết hợp lệ.</p>
                        @else
                            @foreach ($baiviet as $bv)
                                <div class="col-md-3 mb-4">

                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $baiviet->links() }}
                    </div>
                </div>
            </div>

            @include('Baiviet-partials.sidebar')
        </div>
    </div>
@endsection --}}
