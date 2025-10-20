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

    /* Struktur dasar */
    .layout {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    /* SIDEBAR */
    .sidebar {
        width: 230px;
        background: linear-gradient(180deg, #2E7D32, #388E3C);
        padding: 25px 15px;
        color: white;
        transition: all 0.3s ease;
        z-index: 1030;
        flex-shrink: 0;
    }

    .sidebar h2 {
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
    }

    /* MAIN AREA */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #F8F9FA;
        overflow-x: hidden;
    }

    /* TOPBAR */
    .topbar {
        background: #fff;
        border-bottom: 2px solid #e5e5e5;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        position: sticky;
        top: 0;
        z-index: 1040;
    }

    .topbar h4 {
        color: #2E7D32;
        font-size: 18px;
        font-weight: 600;
        text-align: center;
        margin: 0;
        flex-grow: 1;
    }

    .menu-toggle {
        display: none;
        background: none;
        border: 2px solid #2E7D32;
        color: #2E7D32;
        font-size: 20px;
        border-radius: 6px;
        cursor: pointer;
        padding: 4px 10px;
        transition: 0.3s;
    }

    .menu-toggle:hover {
        background: #2E7D32;
        color: #fff;
    }

    /* CONTENT */
    .content {
        flex: 1;
        padding: 25px;
        overflow-x: auto;
    }

    /* FOOTER */
    footer {
        text-align: center;
        padding: 15px;
        background: #ffffff;
        border-top: 1px solid #e5e5e5;
        color: #555;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            height: 100%;
        }

        .sidebar.active {
            left: 0;
        }

        .menu-toggle {
            display: block;
        }

        .content {
            padding: 20px 15px;
        }
    }
    </style>
</head>
<body>
<div class="layout">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>🥥 Es Kelapa</h2>

        {{-- Dashboard --}}
        <div class="sidebar-group {{ request()->is('*dashboard*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Dashboard <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ Auth::user()->hak === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}"
                class="{{ request()->is('*dashboard*') ? 'active' : '' }}">🏠 Dashboard</a>
            </div>
        </div>

        {{-- Produk & Bahan --}}
        @if(Auth::user()->hak === 'admin')
        <div class="sidebar-group {{ request()->is('product*') || request()->is('material*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Produk & Bahan <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }}">🧃 Produk</a>
                <a href="{{ route('material.index') }}" class="{{ request()->is('material*') ? 'active' : '' }}">🌿 Bahan</a>
            </div>
        </div>
        @endif

        {{-- Transaksi --}}
        <div class="sidebar-group {{ request()->is('pembelian*') || request()->is('transaksi*') || request()->is('kasir*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Transaksi <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                @if(Auth::user()->hak === 'admin')
                    <a href="{{ route('pembelian.index') }}" class="{{ request()->is('pembelian*') ? 'active' : '' }}">🛒 Pembelian</a>
                    <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi') || request()->is('transaksi/index') ? 'active' : '' }}">💰 Daftar Transaksi</a>
                    <a href="{{ route('transaksi.create') }}" class="{{ request()->is('transaksi/create') ? 'active' : '' }}">➕ Transaksi Baru</a>
                @else
                    <a href="{{ route('pembelian.index') }}" class="{{ request()->is('pembelian*') ? 'active' : '' }}">🛒 Pembelian</a>
                    <a href="{{ route('transaksi.create') }}" class="{{ request()->is('transaksi/create') ? 'active' : '' }}">💰 Transaksi Baru</a>
                    <a href="{{ route('kasir.riwayat') }}" class="{{ request()->is('kasir/riwayat') ? 'active' : '' }}">📜 Riwayat Transaksi</a>
                @endif
            </div>
        </div>

        {{-- Laporan --}}
        @if(Auth::user()->hak === 'admin')
        <div class="sidebar-group {{ request()->is('laporan*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Laporan <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">📑 Penjualan & Pembelian</a>
            </div>
        </div>

        {{-- Admin --}}
        <div class="sidebar-group {{ request()->is('users*') ? 'open' : '' }}">
            <button class="sidebar-toggle">Admin <span class="arrow">▾</span></button>
            <div class="sidebar-links">
                <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">👥 Pengguna</a>
            </div>
        </div>
        @endif

        {{-- Logout --}}
        <div class="sidebar-footer mt-auto p-3 text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">🔒 Logout</button>
            </form>
        </div>
    </div>

    <!-- Main -->
    <div class="main">
        <div class="topbar" id="topbar">
            <button class="menu-toggle" id="menuToggle">☰</button>
            <h4>Penjualan</h4>
            <div class="user-info">👤 {{ Auth::user()->name }} ({{ Auth::user()->hak }})</div>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <footer>
            <p class="mb-0">🥥 Aplikasi Penjualan Es Kelapa © {{ date('Y') }}</p>
        </footer>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
const toggleBtn = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
const groups = document.querySelectorAll('.sidebar-group');

// Toggle sidebar di HP
toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Dropdown menu di sidebar
groups.forEach(group => {
    const toggle = group.querySelector('.sidebar-toggle');
    toggle.addEventListener('click', () => {
        groups.forEach(g => {
            if (g !== group) g.classList.remove('open');
        });
        group.classList.toggle('open');
    });
});
</script>
</body>
</html>
