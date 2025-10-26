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
        background: radial-gradient(circle at top left, #f1f8e9, #c8e6c9);
        margin: 0;
        overflow-x: hidden;
    }

    .layout {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    /* === SIDEBAR === */
    .sidebar {
        width: 240px;
        background: rgba(46,125,50,0.85);
        backdrop-filter: blur(12px);
        border-right: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 1030;
        box-shadow: 4px 0 25px rgba(0,0,0,0.2);
        transition: transform 0.45s ease-in-out, width 0.4s ease, backdrop-filter 0.3s ease;
    }
    .sidebar.hidden {
        transform: translateX(-250px);
        filter: brightness(0.8);
    }

    /* === Header === */
    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 35px;
        padding: 0 15px;
    }
    .sidebar-header img {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        object-fit: contain;
        box-shadow: 0 0 12px rgba(255,255,255,0.3);
    }
    .sidebar-header h2 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
    }

    /* === Link Style === */
    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: #f5f5f5;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 500;
        margin: 3px 0;
        transition: all 0.35s ease;
        position: relative;
    }
    .sidebar a:hover {
        background: rgba(255,255,255,0.15);
        transform: translateX(5px);
    }
    .sidebar a.active {
        background: rgba(255,255,255,0.25);
        box-shadow: inset 0 0 10px rgba(255,255,255,0.2);
    }

    /* === Dropdown === */
    .sidebar-toggle {
        background: none;
        border: none;
        color: #fff;
        width: 100%;
        text-align: left;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
        transition: 0.3s;
    }
    .sidebar-toggle:hover {
        background: rgba(255,255,255,0.15);
        transform: translateX(5px);
    }

    .arrow {
        transition: transform 0.4s ease;
    }

    .sidebar-links {
        display: flex;
        flex-direction: column;
        margin-left: 20px;
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.5s ease, opacity 0.3s ease;
    }

    .sidebar-group.open .sidebar-links {
        max-height: 400px;
        opacity: 1;
    }
    .sidebar-group.open .arrow {
        transform: rotate(-180deg);
    }

    /* === Logout === */
    .sidebar-footer {
        border-top: 1px solid rgba(255,255,255,0.2);
        padding-top: 20px;
        margin-top: auto;
    }
    .btn-logout {
        width: 100%;
        background: linear-gradient(135deg, #43a047, #2e7d32);
        border: none;
        color: #fff;
        border-radius: 25px;
        padding: 10px 0;
        font-weight: 600;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }
    .btn-logout:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        box-shadow: 0 4px 10px rgba(0,0,0,0.35);
    }

    /* === MAIN === */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #F8F9FA;
        margin-left: 240px;
        transition: margin-left 0.4s ease;
    }
    .main.full {
        margin-left: 0;
    }

    .topbar {
        background: rgba(255,255,255,0.9);
        border-bottom: 2px solid #e0e0e0;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        position: sticky;
        top: 0;
        z-index: 1040;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        backdrop-filter: blur(5px);
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
        transition: 0.3s;
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

    /* Overlay (mobile) */
    .overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 1020;
        display: none;
        opacity: 0;
        backdrop-filter: blur(3px);
        transition: opacity 0.4s ease;
    }
    .overlay.active {
        display: block;
        opacity: 1;
    }

    /* RESPONSIVE */
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
            <img src="{{ asset('icons/house.png') }}" width="22"> Dashboard
        </a>

        @if(Auth::user()->hak === 'admin')
        <div class="sidebar-group {{ request()->is('product*') || request()->is('material*') ? 'open' : '' }}">
            <button class="sidebar-toggle">
                <img src="{{ asset('icons/cooking-pot.png') }}" width="22">Produk & Bahan <span class="arrow">▾</span>
            </button>
            <div class="sidebar-links">
                <a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }}">
                    <img src="{{ asset('icons/cup-soda.png') }}" width="22"> Produk
                </a>
                <a href="{{ route('material.index') }}" class="{{ request()->is('material*') ? 'active' : '' }}">
                    <img src="{{ asset('icons/citrus.png') }}" width="22"> Bahan
                </a>
                <a href="{{ route('produksi.index') }}" class="{{ request()->is('produksi*') ? 'active' : '' }}">
                    <img src="{{ asset('icons/package.png') }}" width="22"> Produksi
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

        @if(Auth::user()->hak === 'admin')
        <a href="{{ route('laporan.index') }}"><img src="{{ asset('icons/file-text.png') }}" width="22"> Laporan</a>
        <a href="{{ route('users.index') }}"><img src="{{ asset('icons/users.png') }}" width="22"> Admin</a>
        @endif

        <div class="sidebar-footer text-center p-3">
            <form action="{{ route('logout') }}" method="POST">@csrf
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

        <div class="content">@yield('content')</div>
        <footer><p class="mb-0">🥥 Aplikasi Penjualan Es Kelapa © {{ date('Y') }}</p></footer>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('menuToggle');
    const overlay = document.getElementById('overlay');
    const main = document.getElementById('main');
    const groups = document.querySelectorAll('.sidebar-group');

    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.toggle('hidden');
            main.classList.toggle('full');
        } else {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    groups.forEach(group => {
        const toggle = group.querySelector('.sidebar-toggle');
        toggle.addEventListener('click', () => {
            groups.forEach(g => { if (g !== group) g.classList.remove('open'); });
            group.classList.toggle('open');
        });
    });
});
</script>
</body>
</html>
