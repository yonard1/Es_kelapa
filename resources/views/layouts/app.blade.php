<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Kelapa - Dashboard</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
    @font-face {
        font-family: 'Poppins';
        src: url('/fonts/Poppins/Poppins-Regular.ttf') format('truetype');
        font-weight: 400;
    }

    @font-face {
        font-family: 'Poppins';
        src: url('/fonts/Poppins/Poppins-SemiBold.ttf') format('truetype');
        font-weight: 600;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #F8F9FA;
        margin: 0;
        overflow-x: hidden;
    }

    .layout {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 230px;
        background: linear-gradient(180deg, #2E7D32, #388E3C);
        padding: 25px 15px;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 1030;
        transform: translateX(0);
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.25);
        transition: transform 0.4s ease, box-shadow 0.4s ease, filter 0.4s ease;
        backdrop-filter: blur(3px);
    }

    .sidebar.hidden {
        transform: translateX(-250px);
        box-shadow: none;
        filter: brightness(0.8);
    }

    /* === Logo + Judul === */
    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        margin-bottom: 30px;
    }

    .sidebar-header img {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }

    .sidebar-header h2 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    /* === Links === */
    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
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
        background: rgba(255, 255, 255, 0.18);
        transform: translateX(4px);
    }

    .sidebar-toggle {
        background: none;
        border: none;
        color: #fff;
        width: 100%;
        text-align: left;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(4px);
    }

    .arrow {
        transition: transform 0.3s ease;
    }

    .sidebar-links {
        display: flex;
        flex-direction: column;
        margin-left: 10px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .sidebar-group.open .sidebar-links {
        max-height: 400px;
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
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #27ae60, #1e8449);
        transform: scale(1.05);
    }

    /* ===== MAIN ===== */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #F8F9FA;
        margin-left: 230px;
        transition: margin-left 0.4s ease;
    }

    .main.full {
        margin-left: 0;
    }

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
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .topbar h4 {
        color: #2E7D32;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        flex-grow: 1;
        text-align: center;
    }

    .menu-toggle {
        background: none;
        border: 2px solid #2E7D32;
        color: #2E7D32;
        font-size: 20px;
        border-radius: 6px;
        cursor: pointer;
        padding: 4px 10px;
        transition: all 0.3s ease;
    }

    .menu-toggle:hover {
        background: #2E7D32;
        color: #fff;
    }

    .content {
        flex: 1;
        padding: 25px;
        overflow-x: auto;
    }

    footer {
        text-align: center;
        padding: 15px;
        background: #ffffff;
        border-top: 1px solid #e5e5e5;
        color: #555;
    }

    /* ===== OVERLAY (mobile) ===== */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1020;
        display: none;
        backdrop-filter: blur(3px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .overlay.active {
        display: block;
        opacity: 1;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-250px);
        }
        .sidebar.active {
            transform: translateX(0);
        }
        .main {
            margin-left: 0;
        }
    }
    </style>
</head>
<body>
<div class="layout">
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('icons/coconut.png') }}" alt="Logo">
            <h2>Es Kelapa</h2>
        </div>

        <a href="{{ Auth::user()->hak === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}" class="{{ request()->is('*dashboard*') ? 'active' : '' }}">
            <img src="{{ asset('icons/house.png') }}" width="22" alt="Dashboard"> Dashboard
        </a>

        @if(Auth::user()->hak === 'admin')
        <div class="sidebar-group {{ request()->is('product*') || request()->is('material*') ? 'open' : '' }}">
            <button class="sidebar-toggle">
                <img src="{{ asset('icons/cooking-pot.png') }}" width="22">Produk & Bahan <span class="arrow">▾</span>
            </button>
            <div class="sidebar-links">
                <a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }}">
                    <img src="{{ asset('icons/cup-soda.png') }}" width="22" alt="Product"> Produk
                </a>
                <a href="{{ route('material.index') }}" class="{{ request()->is('material*') ? 'active' : '' }}">
                    <img src="{{ asset('icons/citrus.png') }}" width="22" alt="Material"> Bahan
                </a>
            </div>
        </div>
        @endif

        <div class="sidebar-group {{ request()->is('pembelian*') || request()->is('transaksi*') ? 'open' : '' }}">
            <button class="sidebar-toggle">
                <img src="{{ asset('icons/badge-dollar-sign.png') }}" width="22">Transaksi<span class="arrow">▾</span>
            </button>
            <div class="sidebar-links">
                <a href="{{ route('pembelian.index') }}">
                    <img src="{{ asset('icons/shopping-cart.png') }}" width="22"> Pembelian
                </a>
                <a href="{{ route('transaksi.create') }}">
                    <img src="{{ asset('icons/shopping-basket.png') }}" width="22"> Transaksi Baru
                </a>
                <a href="{{ route('transaksi.index') }}">
                    <img src="{{ asset('icons/file-clock.png') }}" width="22"> Daftar Transaksi
                </a>
            </div>
        </div>

        <a href="{{ route('laporan.index') }}">
            <img src="{{ asset('icons/file-text.png') }}" width="22"> Laporan
        </a>

        <a href="{{ route('users.index') }}">
            <img src="{{ asset('icons/users.png') }}" width="22"> Admin
        </a>

        <div class="sidebar-footer mt-auto p-3 text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <img src="{{ asset('icons/log-out.png') }}" width="22"> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main" id="main">
        <div class="topbar">
            <button class="menu-toggle" id="menuToggle">☰</button>
            <h4>Dashboard Penjualan</h4>
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
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('menuToggle');
    const overlay = document.getElementById('overlay');
    const main = document.getElementById('main');
    const groups = document.querySelectorAll('.sidebar-group');

    // Toggle sidebar (desktop & mobile)
    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.toggle('hidden');
            main.classList.toggle('full');
        } else {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    });

    // Tutup sidebar kalau klik overlay (mobile)
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
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
});
</script>
</body>
</html>
