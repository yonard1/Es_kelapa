<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Kelapa - Dashboard</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F8F9FA;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 220px;
            height: 100%;
            background: linear-gradient(180deg, #4CAF50, #4DD0E1);
            padding-top: 20px;
            color: white;
        }
        .sidebar h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            margin: 5px 0;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
        }

        /* Navbar atas */
        .topbar {
            margin-left: 220px;
            background: white;
            border-bottom: 2px solid #eee;
            padding: 10px 20px;
        }

        /* Konten */
        .content {
            margin-left: 220px;
            padding: 20px;
        }

        /* Card */
        .card-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        .card-custom h5 {
            color: #4CAF50;
        }

        footer {
            margin-left: 220px;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>🥥 Es Kelapa</h2>
        <a href="{{ Auth::check() && Auth::user()->hak === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}">Dashboard</a>
        <a href="{{ route('product.index') }}"> Produk </a>
        <a href="{{ route('material.index') }}"> Bahan </a>
        @if(Auth::check() && Auth::user()->hak === 'admin')
            <a href="{{ route('users.index') }}"> Kelola Pengguna </a>
        @endif
        <a href="{{route('pembelian.index')}}">Pembelian</a>
        <form action="{{ route('logout') }}" method="POST" class="mt-3 text-center">
            @csrf
            <button type="submit" class="btn btn-sm btn-light">Logout</button>
        </form>
    </div>

    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Dashboard Penjualan</h4>
        <div>
            @auth
                <span class="me-3">👤 {{ Auth::user()->name }} ({{ Auth::user()->hak }})</span>
            @endauth
        </div>
    </div>

    <!-- Konten -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p class="mb-0">🥥 Aplikasi Penjualan Es Kelapa © {{ date('Y') }}</p>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
