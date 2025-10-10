<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Kelapa - Dashboard</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
    @font-face{
        font-family: Poppins;
        src: url('/fonts/Poppins/Poppins-Regular.ttf') format('truetype');
        font-weight: 400;
    }

    @font-face{
        font-family: Poppins;
        src: url('/fonts/Poppins/Poppins-SemiBold.ttf') format('truetype');
        font-weight: 600;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #F8F9FA;
        margin: 0;
        overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 230px;
        height: 100vh;
        background: linear-gradient(180deg, #2E7D32, #388E3C);
        padding: 25px 15px;
        color: white;
        transition: all 0.3s ease;
        z-index: 1050;
    }

    .sidebar h2 {
        color: #fff;
        text-align: center;
        font-size: 22px;
        margin-bottom: 25px;
        font-weight: 600;
    }

    .sidebar a {
        display: block;
        padding: 10px 15px;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        margin: 2px 0;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(4px);
    }

    /* Sidebar collapsible */
    .sidebar-group {
        margin-bottom: 10px;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        color: #fff;
        width: 100%;
        text-align: left;
        padding: 10px 15px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s;
    }

    .sidebar-toggle:hover {
        background: rgba(255,255,255,0.15);
    }

    .arrow {
        transition: transform 0.3s ease;
    }

    .sidebar-links {
        display: flex;
        flex-direction: column;
        margin-left: 5px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .sidebar-group.open .sidebar-links {
        max-height: 500px;
    }

    .sidebar-group.open .arrow {
        transform: rotate(-90deg);
    }

    .sidebar-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 15px;
    }

    .btn-logout {
        width: 100%;
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px 0;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #27ae60, #1e8449);
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
    }

    .btn-logout i {
        vertical-align: middle;
    }

    /* Topbar */
    .topbar {
        margin-left: 230px;
        background: #ffffff;
        border-bottom: 2px solid #e5e5e5;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .topbar .menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        color: #2E7D32;
        cursor: pointer;
    }

    /* Content */
    .content {
        margin-left: 230px;
        padding: 25px;
        transition: margin-left 0.3s ease;
    }

    /* Footer */
    footer {
        margin-left: 230px;
        text-align: center;
        padding: 15px;
        background: #ffffff;
        border-top: 1px solid #e5e5e5;
        color: #555;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            left: -230px;
        }
        .sidebar.active {
            left: 0;
        }
        .topbar {
            margin-left: 0;
        }
        .topbar .menu-toggle {
            display: block;
        }
        .content, footer {
            margin-left: 0;
        }
    }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>🥥 Es Kelapa</h2>

        <!-- Dashboard -->
        <div class="sidebar-group {{ request()->is('dashboard*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Dashboard <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ Auth::check() && Auth::user()->hak === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">🏠 Dashboard</a>
            </div>
        </div>

        <!-- Produk & Bahan -->
        <div class="sidebar-group {{ request()->is('product*') || request()->is('material*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Produk & Bahan <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }}">🧃 Produk</a>
                <a href="{{ route('material.index') }}" class="{{ request()->is('material*') ? 'active' : '' }}">🌿 Bahan</a>
            </div>
        </div>

        <!-- Transaksi -->
        <div class="sidebar-group {{ request()->is('pembelian*') || request()->is('transaksi*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Transaksi <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ route('pembelian.index') }}" class="{{ request()->is('pembelian*') ? 'active' : '' }}">🛒 Pembelian</a>
                <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi*') ? 'active' : '' }}">💰 Transaksi</a>
            </div>
        </div>

        <!-- Laporan -->
        <div class="sidebar-group {{ request()->is('laporan*') ? 'open' : '' }}">
            <button class="sidebar-toggle {{ request()->is('laporan*') ? 'active' : '' }}">
                Laporan <span class="arrow">▾</span>
            </button>
            <div class="sidebar-links">
                <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">📑 Laporan Penjualan & Pembelian</a>
            </div>
        </div>

        <!-- Admin -->
        @if(Auth::check() && Auth::user()->hak === 'admin')
        <div class="sidebar-group {{ request()->is('users*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Admin <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">👥 Pengguna</a>
            </div>
        </div>
        @endif

        <!-- Logout -->
        <div class="sidebar-footer mt-auto p-3 text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <button class="menu-toggle" id="menuToggle">☰</button>
        <h4 class="mb-0 text-success">Dashboard Penjualan</h4>
        <div>
            @auth
                <span class="me-3 text-secondary">👤 {{ Auth::user()->name }} ({{ Auth::user()->hak }})</span>
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
    <script>
    const toggleBtn = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    // Toggle sidebar on mobile
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    // Sidebar dropdown behavior
    const groups = document.querySelectorAll('.sidebar-group');
    groups.forEach(group => {
        const toggle = group.querySelector('.sidebar-toggle');
        toggle.addEventListener('click', () => {
            // Tutup grup lain
            groups.forEach(g => {
                if (g !== group) g.classList.remove('open');
            });
            // Buka/tutup grup yang diklik
            group.classList.toggle('open');
        });
    });
    </script>
</body>
</html>