<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Es Kelapa</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Es Kelapa Logo">
        </div>
        <h2 class="auth-title">Register</h2>

        @if ($errors->any())
            <ul class="alert alert-danger p-2">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
            </div>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Daftar</button>
        </form>

        <p class="mt-3 text-center">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</div>
</body>
</html>
