@extends('layouts.layout')
@section('content')
    <h2>Xác minh OTP</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('verify.form') }}">
        @csrf
        <input type="text" name="otp_code" placeholder="Nhập mã OTP" class="form-control mb-2">
        @error('otp_code')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <button type="submit" class="btn btn-success">Xác thực</button>
    </form>

    <p>Mã xác thực hết hạn sau: <span id="countdown"></span></p>

    <form method="POST" action="{{ route('verify.resend') }}">
        @csrf
        <button type="submit" class="btn btn-primary" id="resendBtn" disabled>Gửi lại mã</button>
    </form>
    <script>
        const expireTime = "{{ \Carbon\Carbon::parse(session('register_otp_expires'))->timestamp }}";
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
            countdownEl.textContent = `${minutes}:${seconds}`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
@endsection
