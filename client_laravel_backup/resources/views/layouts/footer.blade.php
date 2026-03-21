<footer class=" text-white pt-5 bg-white shadow-sm">
    <div class="container text-dark">
        <div class="row gy-4 ">
            <!-- Cột 1: Liên hệ -->
            <div class="col-md-6 col-lg-3 text-dark">

                <h5 class="fw-bold">LIÊN HỆ</h5>
                <p>
                    Chúng tôi chuyên cung cấp các sản phẩm về món bánh và kẹo đặc sản miền tây
                </p>
                <p><i class="bi bi-geo-alt-fill me-2"></i> Công viên phần mềm Quang Trung</p>
                <p><i class="bi bi-telephone-fill me-2"></i> 0325568596<br>Thứ 2 – Chủ nhật: 9:00 – 18:00</p>
                <p><i class="bi bi-envelope-fill me-2"></i> Hưngthịnhspecialfood.vn </p>
            </div>
             <!-- Cột 2: Hỗ trợ khách hàng -->
            <div class=" col-md-2  text-dark">
                <h6 class="fw-bold">THÔNG TIN</h6>
                <ul class="list-unstyled">
                    <li>● <a href="/" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li>● <a href="/sanpham" class="text-decoration-none text-dark">Cửa hàng</a></li>
                    <li>● <a href="/baiviet" class="text-decoration-none text-dark">Bài viết</a></li>
                     <li>● <a href="/lienhe" class="text-decoration-none text-dark">Liên hệ</a></li>
                </ul>
            </div>

            <!-- Cột 2: Hỗ trợ khách hàng -->
            <div class=" col-md-2  text-dark">
                <h6 class="fw-bold">DANH MỤC BÀI VIẾT</h6>
                <ul class="list-unstyled">
                    @foreach($danhmucBv as $danhmucbaiviet)
                    <li>● <a href="{{route('baiviet.danhmuc',$danhmucbaiviet->id)}}" class="text-decoration-none text-dark">{{$danhmucbaiviet->tendm}}</a></li>
                   
                    @endforeach
                </ul>
            </div>

            <!-- Cột 3: Danh mục -->
            <div class="col-md-2">
                <h6 class="fw-bold">DANH MỤC</h6>
                <ul class="list-unstyled k">
                    @foreach ($danhmucAll as $danhmuc)
                        <li>● <a href="{{ route('sanpham.index', ['danhmuc' => [$danhmuc->id]]) }}""
                                class="text-decoration-none text-dark">{{ $danhmuc->tendanhmuc }}</a>
                        </li>
                    @endforeach

                </ul>
            </div>

            <!-- Cột 4: Kết nối -->
            <div class="col-12 col-lg-3">
                <h6 class="fw-bold">KẾT NỐI VỚI CHÚNG TÔI</h6>
                <p><i>Để nhận thêm thông tin ưu đãi</i></p>
                <form class="d-flex mt-2 mt-lg-0" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control me-1" type="search" placeholder="Điền email tại đây...">
                    <button class="btn btn-light text-white" type="submit" style="background-color:#fe9705"><i
                            class="bi bi-send"></i></button>
                </form>
                <div>
            <img style="width:100px; height:auto;" src="{{asset('thanhtoan/vnpay.png')}}" alt="Thanh toán bằng VNPay">
        </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-1 text-center" style="background-color:#80bb35;">
        <i>CopyRight@2025 được tạo dựng bởi Hưng Thịnh Food Special Team</i>
    </div>
</footer>
