<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
        <link rel="icon" href="{{ asset('logo/HungThinh.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #212529;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background-color: #343a40;
            color: #fff;
            border: 1px solid #495057;
        }

        .form-control:focus {
            background-color: #343a40;
            border-color: #495057;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Admin Login</h2>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('login.active') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>

</html>
