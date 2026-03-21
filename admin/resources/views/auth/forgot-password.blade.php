<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #343a40; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #212529; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0 10px rgba(0,0,0,0.5); width: 100%; max-width: 400px; }
        .form-control { background-color: #343a40; color: #fff; border: 1px solid #495057; }
        .form-control:focus { background-color: #343a40; border-color: #495057; box-shadow: none; color: #fff; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Forgot Password</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <p class="text-muted text-center">Enter your email address and we will send you a link to reset your password.</p>
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            <div class="mt-3 text-center">
                <a href="{{ route('login.show') }}" class="text-decoration-none">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
