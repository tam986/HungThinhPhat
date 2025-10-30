@extends('page.layout')
@section('title', 'Thêm sản phẩm')
@section('content')
    <div class="container-fluid p-3">
        <div
            class="container d-flex bg-white shadow rounded align-items-center mt-4 mb-4 p-3 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center gap-4 mt-4 mb-4">
                <i class="bi bi-box-seam text-danger bg-light p-4 rounded fs-4"></i>
                <h4 class="text-dark mb-0 fw-bold">Thêm sản phẩm mới</h4>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded animate__animated animate__shakeX">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('sanpham.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="tensp" class="form-label fw-semibold">Tên sản phẩm</label>
                                <input type="text" class="form-control shadow-sm @error('tensp') is-invalid @enderror"
                                    id="tensp" name="tensp" value="{{ old('tensp') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="id_danhmuc" class="form-label fw-semibold">Danh mục</label>
                                <select class="form-control shadow-sm @error('id_danhmuc') is-invalid @enderror"
                                    id="id_danhmuc" name="id_danhmuc" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach ($danhmucs as $dm)
                                        <option value="{{ $dm->id }}"
                                            {{ old('id_danhmuc') == $dm->id ? 'selected' : '' }}>{{ $dm->tendanhmuc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_nhacungcap" class="form-label fw-semibold">Nhà cung cấp</label>
                                <select class="form-control shadow-sm @error('id_nhacungcap') is-invalid @enderror"
                                    id="id_nhacungcap" name="id_nhacungcap" required>
                                    <option value="">-- Chọn nhà cung cấp --</option>
                                    @foreach ($nhacungcaps as $ncc)
                                        <option value="{{ $ncc->id }}"
                                            {{ old('id_nhacungcap') == $ncc->id ? 'selected' : '' }}>
                                            {{ $ncc->tennhacungcap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mota" class="form-label fw-semibold">Mô tả</label>
                                <textarea class="form-control shadow-sm @error('mota') is-invalid @enderror" id="mota" name="mota"
                                    rows="3">{{ old('mota') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nhân bánh</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($nhanbanh as $nb)
                                        <button type="button" class="btn btn-outline-primary toggle-token shadow-sm"
                                            data-id="{{ $nb->id }}">{{ $nb->tenNhanBanh }}</button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Khối lượng</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($khoiluong as $kl)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bienthe[khoiluong][]"
                                                value="{{ $kl->id }}" id="khoiluong_{{ $kl->id }}"
                                                onchange="updateBienthe()">
                                            <label class="form-check-label"
                                                for="khoiluong_{{ $kl->id }}">{{ $kl->khoiluong }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <label class="form-label fw-semibold">Danh sách biến thể</label>
                                <button type="button" class="btn btn-primary btn-sm shadow-sm" onclick="addBienthe()">
                                    <i class="bi bi-plus-lg d-none d-md-inline"></i> Thêm
                                </button>
                            </div>
                            <div id="bienthe-list" class="mb-3"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('sanpham.index') }}" class="btn btn-outline-secondary shadow-sm"><i
                                class="bi bi-arrow-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary shadow-sm"><i class="bi bi-save"></i> Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const nhanbanhList = @json($nhanbanh->pluck('tenNhanBanh', 'id'));
        const khoiluongList = @json($khoiluong->pluck('khoiluong', 'id'));

        document.querySelectorAll('.toggle-token').forEach(token => {
            token.addEventListener('click', function() {
                this.classList.toggle('active');
                updateBienthe();
            });
        });

        function updateBienthe() {} // Placeholder for consistency

        function addBienthe() {
            const selectedNhanbanh = Array.from(document.querySelectorAll('.toggle-token.active')).map(token => token
                .getAttribute('data-id'));
            const selectedKhoiluong = Array.from(document.querySelectorAll('input[name="bienthe[khoiluong][]"]:checked'))
                .map(checkbox => checkbox.value);

            if (selectedNhanbanh.length === 0 || selectedKhoiluong.length === 0) {
                alert('Vui lòng chọn cả nhân bánh và khối lượng để tạo biến thể.');
                return;
            }

            const bientheList = document.getElementById('bienthe-list');
            selectedKhoiluong.forEach(id_khoiluong => {
                const tenKhoiluong = khoiluongList[id_khoiluong];
                if (selectedNhanbanh.length) {
                    selectedNhanbanh.forEach(id_nhanbanh => {
                        const tenNhanbanh = nhanbanhList[id_nhanbanh];
                        addItems(id_nhanbanh, id_khoiluong, `${tenNhanbanh} - ${tenKhoiluong}`);
                    });
                } else {
                    addItems(null, id_khoiluong, tenKhoiluong);
                }
            });
            resetSelect();
        }

        function addItems(id_nhanbanh, id_khoiluong, labelText) {
            const bientheList = document.getElementById('bienthe-list');
            const key = `${id_nhanbanh || ''}_${id_khoiluong}`;
            if (bientheList.querySelector(`[data-id="${key}"]`)) return;

            const div = document.createElement('div');
            div.className = ' align-items-center gap-2 mb-2 p-2 bienthe-item animate__animated animate__fadeIn';
            div.setAttribute('data-id', key);
            div.innerHTML = `
               <div class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Biến thể</label>
                        <p class="mb-0">${labelText}</p>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Số lượng</label>
                        <input type="number" name="bienthe[soluong][${key}]" class="form-control shadow-sm" placeholder="Số lượng" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Giá</label>
                        <input type="number" name="bienthe[gia][${key}]" class="form-control shadow-sm" placeholder="Giá" min="0" step="1000" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Giá KM</label>
                        <input type="number" name="bienthe[giakm][${key}]" class="form-control shadow-sm" placeholder="Giá KM" min="0" step="1000">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Slug</label>
                        <input type="text" name="bienthe[slug][${key}]" class="form-control shadow-sm slug-input" placeholder="slug" required>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm shadow-sm delete-bienthe position-relative">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <label class="form-label fw-semibold">Hình ảnh</label>
                        <input type="file" name="bienthe[hinh][${key}]" class="form-control shadow-sm">
                    </div> 
                    <input type="hidden" name="bienthe[id_nhanbanh][${key}]" value="${id_nhanbanh || ''}">
                    <input type="hidden" name="bienthe[id_khoiluong][${key}]" value="${id_khoiluong}">  
                </div>
        `;
            bientheList.appendChild(div);
        }

        function resetSelect() {
            document.querySelectorAll('.toggle-token.active').forEach(token => token.classList.remove('active'));
            document.querySelectorAll('input[name="bienthe[khoiluong][]"]:checked').forEach(checkbox => checkbox.checked =
                false);
        }

        document.addEventListener('click', function(event) {
            if (event.target.closest('.delete-bienthe')) {
                const bientheItem = event.target.closest('.bienthe-item');
                bientheItem.classList.add('animate__fadeOut');
                setTimeout(() => bientheItem.remove(), 300);
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 15px;
        }

        .form-control,
        .btn {
            border-radius: 10px;
        }

        .toggle-token {
            border-radius: 25px;
            padding: 8px 15px;
            transition: all 0.3s;
        }

        .toggle-token.active {
            background-color: #007bff;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.3);
        }

        .bienthe-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
        }
    </style>
@endsection
