@extends('page.layout')

@section('content')
    
    <div class="container my-4 my-md-5">
        @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <h5 class="alert-heading">Có lỗi xảy ra!</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h2 class="mb-0 text-success">
                <i class="fas fa-plus-circle me-2"></i>Thêm Bài Viết Mới
            </h2>
            <a href="{{ route('baiviet.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>

        <div class="card shadow-sm border-light">
            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('baiviet.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="postTitle" class="form-label fw-semibold">Tiêu đề:</label>
                        <input type="text" name="tieude" class="form-control form-control-lg"
                            placeholder="Nhập tiêu đề bài viết..." required>
                    </div>

                    <div class="mb-3">
                        <label for="motangan" class="form-label fw-semibold">Mô tả ngắn:</label>
                        <textarea name="motangan" id="motangan" class="form-control" rows="3"
                            placeholder="Mô tả ngắn gọn về nội dung bài viết..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="noidung" class="form-label fw-semibold">Nội dung:</label>
                        <textarea name="noidung" id="noidung" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="row mb-4 align-items-start">
                        <div class="col-md-6">
                            <label for="anhdaidien" class="form-label fw-semibold"><i
                                    class="fas fa-image me-1 text-warning"></i>Ảnh đại diện:</label>
                            <input type="file" name="anhdaidien" id="anhdaidien" class="form-control" accept="image/*">
                            <div class="form-text">Định dạng hợp lệ: JPG, PNG, WEBP.</div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <img id="preview-image-container" src="#" alt="Xem trước ảnh" class="rounded shadow"
                                style="display: none; max-height: 200px;">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary">Tối ưu SEO</h5>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="seotieude" class="form-label">SEO Tiêu đề:</label>
                            <input type="text" name="seotieude" id="seotieude" class="form-control"
                                placeholder="Tiêu đề hiển thị trên Google...">
                        </div>
                        <div class="col-md-6">
                            <label for="postSlug" class="form-label">Slug (URL):</label>
                            <input type="text" name="slug" id="postSlug" class="form-control"
                                placeholder="Nhập slug">
                            <div class="form-text">Slug sẽ được tạo tự động từ tiêu đề.</div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary">Cài đặt khác</h5>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="id_danhmuc" class="form-label fw-semibold">Danh mục:</label>
                            <select name="id_danhmuc" id="id_danhmuc" class="form-select" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($danhMucBaiViet as $danhMuc)
                                    <option value="{{ $danhMuc->id }}">{{ $danhMuc->tendm }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="anhien" class="form-label fw-semibold">Trạng thái hiển thị:</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="anhien_checkbox" name="anhien_checkbox"
                                    value="1" checked>
                                <label class="form-check-label" for="anhien_checkbox" id="anhien-label">Hiển thị</label>
                            </div>
                            <input type="hidden" name="anhien" id="anhien" value="1">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success btn-md">
                            <i class="fas fa-plus me-1"></i> Đăng bài viết
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Loaded'); 

            const postTitleSeoInput = document.getElementById('seotieude');
            const postSlugInput = document.getElementById('postSlug');
            const anhdaidienInput = document.getElementById('anhdaidien');
            const previewImage = document.getElementById('preview-image-container');
            const editorElement = document.querySelector('#noidung');

            if (postTitleSeoInput && postSlugInput) {
                console.log('Attaching slug listener to:', postTitleSeoInput);
                postTitleSeoInput.addEventListener('input', function() {
                    console.log('Title input event fired. Value:', this.value);
                    try {
                        const slug = generateSlug(this.value);
                        console.log('Generated slug:', slug);
                        postSlugInput.value = slug;
                    } catch (e) {
                        console.error('Error during slug generation:', e);
                    }
                });
            } else {
                console.error('Title or Slug input not found!');
            }
            function generateSlug(text) {
                if (!text) return '';
                text = text.toLowerCase();
                text = removeDiacritics(text);
                text = text.replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                return text;
            }

            function removeDiacritics(str) {
                return str.normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/đ/g, 'd')
                    .replace(/Đ/g, 'd');;
            }


            const anhienCheckbox = document.getElementById('anhien_checkbox');
            const anhienLabel = document.getElementById('anhien-label');
            const anhienHidden = document.getElementById('anhien');

            if (anhienCheckbox && anhienLabel && anhienHidden) {
                anhienCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        anhienHidden.value = "1";
                        anhienLabel.innerText = 'Hiển thị';
                    } else {
                        anhienHidden.value = "0";
                        anhienLabel.innerText = 'Ẩn';
                    }
                    console.log('Giá trị gửi đi:', anhienHidden.value);
                });
            } else {
                console.error('Không tìm thấy checkbox, label hoặc hidden input của "anhien"!');
            }

            if (anhdaidienInput && previewImage) {
                anhdaidienInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        previewImage.src = URL.createObjectURL(file);
                        previewImage.style.display = 'block';
                    } else {
                        previewImage.src = '#';
                        previewImage.style.display = 'none';
                    }
                });
            }
            // Khởi tạo CKEditor
            if (editorElement) {
                ClassicEditor.create(editorElement, {
                    ckfinder: {
                        uploadUrl: '{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}'
                    }
                }).catch(error => {
                    console.error('Lỗi CKEditor:', error);
                });
            }

        });
    </script>
@endsection
