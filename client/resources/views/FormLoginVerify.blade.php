@extends('layouts.layout')
@section('content')
    <div class="container mt-5" style="max-width: 400px">
        <h3 class="text-center mb-4">Xác thực đăng nhập</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/login-verify') }}">
            @csrf
            <div class="mb-3">
                <label>Nhập mã xác thực đã gửi đến email</label>
                <input type="text" name="code" class="form-control" placeholder="Mã xác thực" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Xác thực và đăng nhập</button>
        </form>
        <div class="text-center mt-3">
            <span id="countdown" style="font-weight: bold; color: #d9534f;"></span><br>
            <form method="POST" action="{{ route('resend.login.otp') }}" id="resendForm">
                @csrf
                <button type="submit" id="resendBtn" class="btn btn-link" style="padding: 0;" disabled>Gửi lại mã</button>
            </form>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('login.form') }}">← Quay lại đăng nhập</a>
        </div>
    </div>
    <script>
        const expireTime = "{{ \Carbon\Carbon::parse(session('login_otp_expires'))->timestamp }}";
        const countdownEl = document.getElementById("countdown");
        const resendBtn = document.getElementById("resendBtn");

        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            let diff = expireTime - now;

            if (diff <= 0) {
                countdownEl.textContent = "Mã đã hết hạn";
                resendBtn.disabled = false;
                return;
            }

            const minutes = Math.floor(diff / 60).toString().padStart(2, '0');
            const seconds = (diff % 60).toString().padStart(2, '0');
            countdownEl.textContent = `Mã sẽ hết hạn sau: ${minutes}:${seconds}`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

@endsection
