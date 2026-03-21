<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temporary Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #343a40; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #212529; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0 10px rgba(0,0,0,0.5); width: 100%; max-width: 450px; }
        .form-control { background-color: #343a40; color: #fff; border: 1px solid #495057; }
        .form-control:focus { background-color: #343a40; border-color: #495057; box-shadow: none; color: #fff; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Temp Admin Register</h2>
        <div class="alert alert-warning py-2 small">Note: Password will be hashed using Argon2id.</div>
        <form action="{{ route('register.temp.active') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="hoten" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('hoten') is-invalid @enderror" id="hoten" name="hoten" value="{{ old('hoten') }}" required>
                @error('hoten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register Admin</button>
            <div class="mt-3 text-center">
                <a href="{{ route('login.show') }}" class="text-decoration-none">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
