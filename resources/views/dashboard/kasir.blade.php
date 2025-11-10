@extends('layouts.app')

@section('content')
<style>
    .kasir-dashboard {
        animation: fadeIn 0.7s ease-in-out;
    }

    .kasir-card {
        border: none;
        border-radius: 16px;
        color: #fff;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .kasir-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .kasir-card .card-body {
        padding: 24px 20px;
    }

    .kasir-card h3 {
        font-weight: 600;
        margin-top: 8px;
    }

    .kasir-card i {
        font-size: 36px;
        opacity: 0.9;
    }

    .kasir-card.omzet {
        background: linear-gradient(135deg, #43a047, #2e7d32);
    }

    .kasir-card.transaksi {
        background: linear-gradient(135deg, #1976d2, #0d47a1);
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<div class="container kasir-dashboard text-center py-4">
    <h3 class="mb-4 fw-bold text-success">🍈 Dashboard Kasir</h3>

    <div class="row justify-content-center">
        <!-- Omzet Hari Ini -->
        <div class="col-md-4 mb-3">
            <div class="card kasir-card omzet shadow">
                <div class="card-body">
                    <i class="bi bi-cash-stack"></i>
                    <h6 class="mt-2">Omzet Hari Ini</h6>
                    <h3>Rp {{ number_format($totalPenjualanKasirHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Jumlah Transaksi -->
        <div class="col-md-4 mb-3">
            <div class="card kasir-card transaksi shadow">
                <div class="card-body">
                    <i class="bi bi-receipt-cutoff"></i>
                    <h6 class="mt-2">Jumlah Transaksi Hari Ini</h6>
                    <h3>{{ $totalTransaksiKasirHariIni }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection
