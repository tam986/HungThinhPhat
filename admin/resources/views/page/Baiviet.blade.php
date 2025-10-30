 <div class="container mt-4">
     <div class="container bg-white shadow-sm rounded d-flex align-items-center mb-4 p-0">
         <div class="container d-flex align-items-center gap-4 mt-4 mb-4 pl-0 pt-4 pb-4">
             <div><i class="bi bi-bookmark text-danger bg-light p-4 rounded fs-4"></i></div>
             <div>
                 <h5 class="text-dark">Quản lý danh sách bài viết</h5>
                 <span class="ml-3 text-muted text-end">
                     Hiện <b class="text-primary">{{ $baiViets->count() }}</b> trong
                     tổng <b class="text-success">{{ $baiViets->total() }}</b> bài viết
                 </span>
             </div>
         </div>

         <div class="container d-flex justify-content-end">
             <a href="{{ route('baiviet.create') }}" class="btn btn-primary">
                 <i class="bi bi-plus fs-w-20"></i> Bài viết mới
             </a>
         </div>
     </div>

     @if (session('success'))
         <div class="alert alert-success">{{ session('success') }}</div>
     @endif

     <div class="card bg-white shadow-sm border-0 text-white mb-4">
         <div class="card-body">
             <a href="{{ route('baiviet.index') }}" class="btn btn-outline-primary mb-3">Danh sách bài viết</a>
             <a href="{{ route('baiviet.trashed') }}" class="btn btn-secondary mb-3">
                 <i class="bi bi-trash"></i> Thùng rác
             </a>
             <div class="d-flex justify-content-between align-items-center mb-3">
                 <div class="d-flex gap-4 align-items-center">
                     <form action="" method="GET" class="input-group w-auto mr-3">
                         <input type="text" name="search" class="form-control bg-white text-black"
                             placeholder="Tìm kiếm..." value="{{ request('search') }}">
                         <button class="btn btn-outline-dark border-0 shadow-sm" type="submit">
                             <i class="fas fa-search"></i>
                         </button>
                     </form>

                     <!-- Bộ lọc Sắp xếp -->
                     <form action="" method="GET" class="d-inline">
                         <select name="sort" class="form-control bg-white text-dark w-auto"
                             onchange="this.form.submit()">
                             <option value="" class="text-center">--- Sắp xếp ---</option>
                             <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất
                             </option>
                             <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Tên A-Z</option>
                             <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Tên Z-A</option>
                         </select>
                     </form>

                     <!-- Bộ lọc Theo danh mục -->
                     <form action="" method="GET" class="d-inline">
                         <select name="category" class="form-control bg-white text-dark w-auto"
                             onchange="this.form.submit()">
                             <option value="">--- Danh mục ---</option>
                             @foreach ($danhMucBaiViet as $dm)
                                 <option value="{{ $dm->id }}"
                                     {{ request('category') == $dm->id ? 'selected' : '' }}>
                                     {{ $dm->tendm }}
                                 </option>
                             @endforeach
                         </select>
                     </form>

                     <!-- Bộ lọc Theo trạng thái -->
                     <form action="" method="GET" class="d-inline">
                         <select name="status" class="form-control bg-white text-dark w-auto"
                             onchange="this.form.submit()">
                             <option value="">--- Trạng thái ---</option>
                             <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hiện</option>
                             <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                         </select>
                     </form>
                 </div>
             </div>


             <table class="table table-hover table-white">
                 <thead>
                     <tr>
                         <th scope="col">STT</th>
                         <th scope="col">Tiêu đề</th>
                         <th scope="col">Người viết</th>
                         <th scope="col">Ảnh đại diện</th>
                         <th scope="col">Danh mục bài viết</th>
                         <th scope="col">Slug</th>
                         <th scope="col">Ẩn / Hiện</th>
                         <th scope="col">Hành động</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($baiViets as $baiviet)
                         <tr>
                             <td>{{ $baiviet->id }}</td>
                             <td>{{ $baiviet->tieude }}</td>
                             <td>{{ $baiviet->user->hoten }}</td>
                             <td><img src="{{ asset('storage/' . $baiviet->anhdaidien) }}" alt="Ảnh"
                                     width="100"></td>
                             <td>{{ $baiviet->danhmucbaiviet->tendm ?? 'Chưa có danh mục' }}</td>
                             <td>{{ $baiviet->slug }}
                                 a
                             </td>
                             <td class="text-center col-2 col-md-1">
                                 @if ($baiviet->anhien == 1)
                                     <a href="{{ route('baiviet.active', $baiviet->id) }}">
                                         <i class="bi bi-eye-fill text-success"></i>
                                     </a>
                                 @else
                                     <a href="{{ route('baiviet.unactive', $baiviet->id) }}">
                                         <i class="bi bi-eye-slash-fill text-danger"></i>
                                     </a>
                                 @endif
                             </td>
                             <td>
                                 <a href="{{ route('baiviet.show', $baiviet->id) }}" class="btn btn-warning btn-sm">
                                     <i class="bi bi-pencil-square"></i>
                                 </a>

                                 <form action="{{ route('baiviet.softDelete', $baiviet->id) }}" method="POST"
                                     class="d-inline">
                                     @csrf
                                     @method('DELETE')
                                     <button class="btn btn-danger btn-sm"
                                         onclick="return confirm('Bạn có chắc muốn xóa bài viết này không?')">
                                         <i class="bi bi-trash"></i>
                                     </button>
                                 </form>
                             </td>
                         </tr>
                     @endforeach
                     @if ($baiViets->isEmpty())
                         <tr>
                             <td colspan="9" class="text-center">Không tìm thấy bài viết phù hợp.</td>
                         </tr>
                     @endif
                 </tbody>
             </table>
         </div>
     </div>

     <div class="d-flex justify-content-center mt-3">
         {{ $baiViets->links('pagination::bootstrap-5') }}
     </div>
 </div>
