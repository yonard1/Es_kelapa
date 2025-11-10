<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Kelapa - Dashboard</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('logo/SR.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('logo/SR.png') }}">

    <style>
    /* === FONT === */
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

    /* === SIDEBAR === */
    .sidebar {
        width: 240px;
        background: rgba(46, 125, 50, 0.9);
        backdrop-filter: blur(15px);
        color: #fff;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1030;
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.25);
        transform: translateX(0);
        transition: transform 0.4s ease, backdrop-filter 0.4s ease, width 0.3s ease;
    }
    .sidebar.hidden { transform: translateX(-250px); }

    /* === SIDEBAR HEADER === */
    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
        animation: fadeIn 0.8s ease;
    }
    .sidebar-header img {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        object-fit: cover;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        box-shadow: 0 0 15px rgba(255,255,255,0.4);
    }
    .sidebar-header:hover img {
        transform: scale(1.08);
        box-shadow: 0 0 20px rgba(255,255,255,0.7);
    }
    .sidebar-header h2 {
        font-size: 21px;
        font-weight: 600;
        margin: 0;
        color: #fff;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    /* === LINKS === */
    .sidebar a, .sidebar-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        color: #f5f5f5;
        text-decoration: none;
        border-radius: 10px;
        margin: 3px 0;
        font-weight: 500;
        transition: all 0.3s ease;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        position: relative;
    }
    .sidebar a:hover, .sidebar-toggle:hover {
        background: rgba(255,255,255,0.15);
        transform: translateX(4px);
    }

    .sidebar a.active {
        background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.05));
        box-shadow: inset 0 0 10px rgba(255,255,255,0.2);
    }
    .sidebar a.active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #ffffff;
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 8px rgba(255,255,255,0.7);
    }

    .arrow { transition: transform 0.3s ease; }
    .sidebar-links {
        display: flex;
        flex-direction: column;
        margin-left: 18px;
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.5s ease, opacity 0.4s ease;
    }
    .sidebar-group.open .sidebar-links {
        max-height: 400px;
        opacity: 1;
    }
    .sidebar-group.open .arrow {
        transform: rotate(-180deg);
    }

    .sidebar-footer {
        margin-top: auto;
        border-top: 1px solid rgba(255,255,255,0.2);
        padding: 18px;
    }
    .btn-logout {
        width: 100%;
        background: linear-gradient(135deg, #43a047, #2e7d32);
        border: none;
        color: #fff;
        border-radius: 25px;
        padding: 10px 0;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }
    .btn-logout:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        box-shadow: 0 4px 10px rgba(0,0,0,0.35);
    }

    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #F8F9FA;
        margin-left: 240px;
        transition: margin-left 0.4s ease;
    }
    .main.full { margin-left: 0; }

    .topbar {
        background: rgba(255,255,255,0.95);
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
    }
    .menu-toggle {
        border: 2px solid #2E7D32;
        color: #2E7D32;
        background: none;
        border-radius: 6px;
        font-size: 20px;
        padding: 4px 10px;
        cursor: pointer;
        transition: 0.3s;
    }
    .menu-toggle:hover {
        background: #2E7D32;
        color: #fff;
    }

    .content { padding: 25px; flex: 1; overflow-x: auto; }
    footer {
        text-align: center;
        padding: 15px;
        background: #fff;
        border-top: 1px solid #e5e5e5;
        color: #555;
    }

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

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-260px); }
        .sidebar.active { transform: translateX(0); box-shadow: 5px 0 25px rgba(0,0,0,0.3); }
        .main { margin-left: 0; }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body>
<div class="layout">
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('logo/SR_2.png') }}" alt="Logo Es Kelapa">
            <h2>Es Kelapa</h2>
        </div>

        <a href="{{ Auth::user()->hak === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}" 
           class="{{ request()->is('*dashboard*') ? 'active' : '' }}">
           <img src="{{ asset('icons/house.png') }}" width="22"> Dashboard
        </a>

        @if(Auth::user()->hak === 'admin')
        <div class="sidebar-group {{ request()->is('product*') || request()->is('material*') || request()->is('produksi*') ? 'open' : '' }}">
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

        {{-- Transaksi untuk admin & kasir --}}
        <div class="sidebar-group {{ request()->is('pembelian*') || request()->is('transaksi*') || request()->is('kasir/riwayat*') ? 'open' : '' }}">
            <button class="sidebar-toggle">
                <img src="{{ asset('icons/badge-dollar-sign.png') }}" width="22">Transaksi<span class="arrow">▾</span>
            </button>
            <div class="sidebar-links">
                @if(Auth::user()->hak === 'admin')
                    <a href="{{ route('pembelian.index') }}" class="{{ request()->is('pembelian*') ? 'active' : '' }}">
                        <img src="{{ asset('icons/shopping-cart.png') }}" width="22"> Pembelian
                    </a>
                    <a href="{{ route('transaksi.create') }}" class="{{ request()->is('transaksi/create') ? 'active' : '' }}">
                        <img src="{{ asset('icons/shopping-basket.png') }}" width="22"> Transaksi Baru
                    </a>
                    <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}">
                        <img src="{{ asset('icons/file-clock.png') }}" width="22"> Daftar Transaksi
                    </a>
                @endif

                @if(Auth::user()->hak === 'kasir')
                    <a href="{{ route('pembelian.index') }}" class="{{ request()->is('pembelian*') ? 'active' : '' }}">
                        <img src="{{ asset('icons/shopping-cart.png') }}" width="22"> Pembelian
                    </a>
                    <a href="{{ route('transaksi.create') }}" class="{{ request()->is('transaksi/create') ? 'active' : '' }}">
                        <img src="{{ asset('icons/shopping-basket.png') }}" width="22"> Transaksi Baru
                    </a>
                    <a href="{{ route('kasir.riwayat') }}" class="{{ request()->is('kasir/riwayat*') ? 'active' : '' }}">
                        <img src="{{ asset('icons/file-clock.png') }}" width="22"> Riwayat Transaksi
                    </a>
                @endif
            </div>
        </div>

        @if(Auth::user()->hak === 'admin')
            <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">
                <img src="{{ asset('icons/file-text.png') }}" width="22"> Laporan
            </a>
            <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">
                <img src="{{ asset('icons/users.png') }}" width="22"> Admin
            </a>
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
