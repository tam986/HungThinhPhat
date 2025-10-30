@extends('layouts.layout')
@section('title', 'Trang chủ')
@section('subtitle', 'Liên hệ')
@section('content')
    <div class="container py-5">

        {{-- Tiêu đề nổi bật --}}
        <div class="bg-white text-black text-center rounded p-4 mb-5 shadow-sm">
            <img src="{{ asset('logo/HungThinh.png') }}" alt="" class="img-fluid mb-3"
                style="width: 100px; height: 100px;">
            <h2 class="fw-bold mb-2">Liên hệ với chúng tôi</h2>
            <p class="mb-0">Chúng tôi luôn sẵn sàng lắng nghe và phản hồi bạn trong thời gian sớm nhất!</p>
        </div>

        <div class="row">
            {{-- Thông tin liên hệ --}}
            <div class="col-md-6 mb-4 fs-5">
                <h4 class="fw-bold mb-3">Thông tin liên hệ</h4>
                <p>Công ty Hưng Thịnh Phát chuyên cung cấp đặc sản miền Tây chất lượng cao, đảm bảo nguồn gốc và uy tín.</p>

                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="bi bi-map-fill me-2 text-primary"></i>
                        Cao đẳng FPT Polytechnic, Quận 12, TP. HCM
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i>
                        0909 123 456
                    </li>
                    <li class="mb-3">
                        <i class="bi me-2 bi-envelope-at-fill text-primary"></i>

                        Email@email.com
                    </li>
                </ul>

                <h5 class="mt-4">Mạng xã hội</h5>
                <div class="mt-2">
                    <a href="#" class="me-3 text-decoration-none text-primary"><i class="bi bi-facebook fs-1"></i></a>
                    <a href="#" class="me-3 text-decoration-none text-primary"><i
                            class="bi bi-instagram fs-1"></i></a>
                    <a href="#" class="me-3 text-decoration-none text-danger border-1"><i
                            class="bi bi-youtube fs-1"></i></a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-white rounded shadow p-4">
                    <h4 class="fw-bold mb-3">Gửi tin nhắn</h4>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('lienhe.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tên của bạn</label>
                            <input type="text" name="ten" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" name="tieude" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea name="noidung" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning px-4">Gửi liên hệ</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bản đồ --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-3">Bản đồ</h4>
            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.4352184395725!2d106.64225697460385!3d10.855574257764409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752d16b1d3f52d%3A0x91499c56a5d476b!2zQ8O0bmcgdmnDqm4gcGjhuqFtIG3hu5l Quang Trung, Quận 12, Hồ Chí Minh, Việt Nam!5e0!3m2!1svi!2s!4v1712731272752!5m2!1svi!2s"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
@endsection
