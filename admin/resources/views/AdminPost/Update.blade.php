@extends('page.layout')
@section('content')
    <div class="container my-4 my-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-edit me-2"></i>Chỉnh Sửa Bài Viết
            </h2>
            <a href="{{ route('baiviet.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Về trang chủ
            </a>
        </div>

        <div class="card shadow-sm border-light">
            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('baiviet.update', $baiViet->id) }}" method="POST" enctype="multipart/form-data"
                    id="editPostForm">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="postTitle" class="form-label fw-semibold"><i
                                    class="fas fa-heading me-1 text-primary"></i>Tiêu đề:</label>
                            <input type="text" name="tieude" id="postTitle"
                                class="form-control form-control-lg {{ $errors->has('tieude') ? 'is-invalid' : '' }}"
                                value="{{ old('tieude', $baiViet->tieude) }}" required
                                placeholder="Nhập tiêu đề bài viết...">
                            @error('tieude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="motangan" class="form-label fw-semibold"><i
                                    class="fas fa-paragraph me-1 text-info"></i>Mô tả ngắn:</label>
                            <textarea name="motangan" id="motangan" class="form-control {{ $errors->has('motangan') ? 'is-invalid' : '' }}"
                                rows="3" placeholder="Mô tả ngắn gọn về nội dung bài viết...">{{ old('motangan', $baiViet->motangan) }}</textarea>
                            @error('motangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="noidung" class="form-label fw-semibold"><i
                                    class="fas fa-file-alt me-1 text-success"></i>Nội dung:</label>
                            <textarea name="noidung" id="noidung" class="form-control {{ $errors->has('noidung') ? 'is-invalid' : '' }}"
                                rows="5">{{ old('noidung', $baiViet->noidung) }}</textarea>
                            @error('noidung')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-md-7">
                            <label for="anhdaidien" class="form-label fw-semibold"><i
                                    class="fas fa-image me-1 text-warning"></i>Ảnh đại diện:</label>
                            <input type="file" name="anhdaidien" id="anhdaidien"
                                class="form-control {{ $errors->has('anhdaidien') ? 'is-invalid' : '' }}" accept="image/*">
                            <div class="form-text">Chọn ảnh mới để thay thế ảnh hiện tại (nếu có). Định dạng: JPG, PNG,
                                WEBP.</div>
                            @error('anhdaidien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5 mt-2 mt-md-0 text-center text-md-start">
                            @if ($baiViet->anhdaidien)
                                <label class="form-label fw-semibold">Ảnh hiện tại:</label>
                                <div class="image-preview-container">
                                    <img src="{{ asset('storage/' . $baiViet->anhdaidien) }}" alt="Ảnh đại diện hiện tại"
                                        class="image-preview img-thumbnail" style="max-height: 200px;">
                                </div>
                            @else
                                <div class="text-muted mt-4"><i class="fas fa-camera me-1"></i> Chưa có ảnh đại diện.</div>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary"><i class="fas fa-search me-1"></i> Tối ưu SEO</h5>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="seotieude" class="form-label"><i class="fab fa-google me-1 text-danger"></i>SEO Tiêu
                                đề:</label>
                            <input type="text" name="seotieude" id="seotieude"
                                class="form-control {{ $errors->has('seotieude') ? 'is-invalid' : '' }}"
                                value="{{ old('seotieude', $baiViet->seotieude) }}"
                                placeholder="Tiêu đề hiển thị trên Google...">
                            @error('seotieude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="postSlug" class="form-label"><i class="fas fa-link me-1 text-info"></i>Slug
                                (URL):</label>
                            <input type="text" name="slug" id="postSlug"
                                class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                                value="{{ old('slug', $baiViet->slug) }}" placeholder="Nhập slug">
                            <div class="form-text">Slug sẽ được tạo tự động từ tiêu đề, bạn có thể sửa lại nếu cần.</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary"><i class="fas fa-cogs me-1"></i> Cài đặt khác</h5>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="id_danhmuc" class="form-label fw-semibold"><i
                                    class="fas fa-folder-open me-1 text-primary"></i>Danh mục:</label>
                            <select name="id_danhmuc" id="id_danhmuc"
                                class="form-select {{ $errors->has('id_danhmuc') ? 'is-invalid' : '' }}" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($danhMucBaiViet as $danhMuc)
                                    <option value="{{ $danhMuc->id }}"
                                        {{ old('id_danhmuc', $baiViet->id_danhmuc) == $danhMuc->id ? 'selected' : '' }}>
                                        {{ $danhMuc->tendm }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_danhmuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="trangthai" class="form-label fw-semibold"><i
                                    class="fas fa-check-circle me-1 text-info"></i>Trạng thái:</label>
                            <select name="trangthai" id="trangthai"
                                class="form-select {{ $errors->has('trangthai') ? 'is-invalid' : '' }}" required>
                                <option value="chờ duyệt"
                                    {{ old('trangthai', $baiViet->trangthai) == 'chờ duyệt' ? 'selected' : '' }}>
                                    Chờ duyệt
                                </option>
                                <option value="đã duyệt"
                                    {{ old('trangthai', $baiViet->trangthai) == 'đã duyệt' ? 'selected' : '' }}>
                                    Đã duyệt
                                </option>
                                <option value="từ chối"
                                    {{ old('trangthai', $baiViet->trangthai) == 'từ chối' ? 'selected' : '' }}>
                                    Từ chối
                                </option>
                            </select>
                            @error('trangthai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="col-md-4">
                            <label for="anhien" class="form-label fw-semibold">
                                <i class="fas fa-eye me-1 text-success"></i>Trạng thái hiển thị:
                            </label>

                            <div class="form-check form-switch">
                                <input type="hidden" name="anhien" value="0">

                                <input type="checkbox"
                                    class="form-check-input {{ $errors->has('anhien') ? 'is-invalid' : '' }}"
                                    id="anhien_checkbox" name="anhien" value="1"
                                    {{ old('anhien', $baiViet->anhien) ? 'checked' : '' }}>

                                <label class="form-check-label" for="anhien_checkbox" id="anhien-label">
                                    {{ old('anhien', $baiViet->anhien) ? 'Hiển thị' : 'Ẩn' }}
                                </label>
                            </div>

                            @error('anhien')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <a href="{{ route('baiviet.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary btn-md">
                            <i class="fas fa-save me-1"></i> Cập nhật bài viết
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
