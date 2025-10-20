@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3 class="mb-4">Dashboard Kasir</h3>

    <div class="row justify-content-center">
        <!-- Omzet Hari Ini -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h6 class="text-success">Omzet Hari Ini</h6>
                    <h3>Rp {{ number_format($totalPenjualanKasirHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Jumlah Transaksi -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h6 class="text-primary">Jumlah Transaksi Hari Ini</h6>
                    <h3>{{ $totalTransaksiKasirHariIni }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
