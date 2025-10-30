<!DOCTYPE html>
<html>

<head>
    <title>Kết quả thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                @if ($status == 'success')
                    <h1 class="text-success">Thanh toán thành công!</h1>
                    <p>{{ $message }}</p>
                @elseif ($status == 'error')
                    <h1 class="text-danger">Thanh toán thất bại!</h1>
                    <p>{{ $message }}</p>
                @else
                    <h1 class="text-info">Thông tin</h1>
                    <p>{{ $message }}</p>
                @endif
                <a href="{{ route('sanpham.index') }}" class="btn btn-primary mt-3">Quay lại cửa hàng</a>
            </div>
        </div>
    </div>
</body>

</html>
