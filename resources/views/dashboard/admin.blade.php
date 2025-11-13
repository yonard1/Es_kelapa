@extends('layouts.app')

@section('content')
<style>
    /* 🌿 Tema Utama Dashboard */
    body {
        background-color: #f7faf9;
        font-family: 'Poppins', sans-serif;
    }

    /* 🎨 Card Style */
    .card {
        transition: all 0.2s ease-in-out;
        border-radius: 18px;
        border: none;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(46, 125, 50, 0.15);
    }

    /* 💰 Warna Nilai */
    .card-body h3 {
        color: #2E7D32;
        font-weight: 700;
    }

    .card-body h6 {
        color: #6c757d;
        font-weight: 600;
    }

    /* 🧾 Filter Dropdown */
    select.form-select {
        border: 1px solid #cde5cd;
        color: #2E7D32;
    }

    select.form-select:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15);
    }

    .btn-primary {
        background-color: #2E7D32;
        border: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #256b2b;
    }

    /* ⚠️ Alert */
    .alert-warning {
        border: none;
        border-left: 6px solid #ffb300;
        background: #fffbe6;
    }

    /* 📦 Section Title */
    .section-title {
        color: #2E7D32;
        font-weight: 700;
    }

    /* 🔝 Produk & Material Cards */
    .top-products .card,
    .material-list .card {
        border-radius: 16px;
        border: 1px solid #e6f0e6;
    }

    .top-products h5, .material-list h5 {
        color: #2E7D32;
    }

    .text-secondary {
        color: #6b7280 !important;
    }

    /* 📈 Chart Container */
    #penjualanPembelianChart {
        max-height: 380px;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        h3.fw-bold {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container py-4">

    {{-- 🏷️ Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-3 mb-md-0">📊 Selamat Data Admin</h3>
        <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex flex-wrap gap-2 ">
            <select name="bulan" class="form-select w-auto">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="form-select w-auto">
                @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary px-4 shadow-sm">Filter</button>
        </form>
    </div>

    {{-- 💳 Summary Cards --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['title' => 'Omzet Hari Ini', 'value' => $totalPenjualanHariIni],
                ['title' => 'Total Pembelian Bulan Ini', 'value' => $totalPembelianBulanIni],
                ['title' => "Omzet " . DateTime::createFromFormat('!m', $bulan)->format('F') . " $tahun", 'value' => $totalTransaksiBulanIni],
                ['title' => 'Laba Bulan Ini', 'value' => $keuntungan]
            ];
        @endphp
        @foreach ($cards as $card)
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="mb-2">{{ $card['title'] }}</h6>
                    <h3>Rp{{ number_format($card['value'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ⚠️ Warning stok --}}
    @if ($stokHampirHabis->count() > 0)
        <div class="alert alert-warning rounded-4 shadow-sm">
            <h5 class="fw-bold mb-2 text-warning-emphasis">⚠️ Peringatan: Stok Hampir Habis</h5>
            <ul class="mb-0">
                @foreach ($stokHampirHabis as $bhn)
                    <li>{{ $bhn->nama_bahan }}: <strong>{{ $bhn->stok }}</strong> {{ $bhn->satuan }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 📈 Chart Section --}}
    <div class="card border-0 shadow-sm rounded-4 my-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3 section-title">📊 Grafik Penjualan & Pembelian per Bulan</h5>
            <canvas id="penjualanPembelianChart" height="120"></canvas>
        </div>
    </div>

    {{-- 🔝 Produk Terlaris --}}
    <h5 class="fw-bold mt-5 mb-3 section-title">🔥 Produk Terlaris</h5>
    <div class="row g-3 top-products">
        @foreach ($topProducts as $product)
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    @if ($product->produk )
                        <h5 class="fw-bold">{{ $product->produk->nama_produk }}</h5>
                    @else
                        <p class="text-muted">Produk tidak ditemukan</p>
                    @endif
                    <p class="text-secondary">Terjual: {{ $product->total_terjual }} unit</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
const ctx = document.getElementById('penjualanPembelianChart');
const penjualanPembelianChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
        datasets: [
            {
                label: 'Penjualan',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                        {{ $penjualanPerBulan[$i] ?? 0 }}{{ $i < 12 ? ',' : '' }}
                    @endfor
                ],
                backgroundColor: 'rgba(46, 125, 50, 0.4)',
                borderColor: 'rgba(46, 125, 50, 1)',
                borderWidth: 1,
            },
            {
                label: 'Pembelian',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                        {{ $pembelianPerBulan[$i] ?? 0 }}{{ $i < 12 ? ',' : '' }}
                    @endfor
                ],
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgba(255, 99, 132, 0.9)',
                borderWidth: 1,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: v => 'Rp ' + v.toLocaleString() }
            }
        }
    }
});

function updateTopProducts() {
    $.get('{{ route('get.top.products') }}', function(response) {
        let html = '';
        response.topProducts.forEach(p => {
            html += `
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">${p.produk ? p.produk.nama_produk : 'Produk tidak ditemukan'}</h5>
                        <p class="text-secondary">Terjual: ${p.total_terjual} unit</p>
                    </div>
                </div>
            </div>`;
        });
        $('.top-products').html(html);
    });
}
setInterval(updateTopProducts, 10000);
</script>
@endsection
