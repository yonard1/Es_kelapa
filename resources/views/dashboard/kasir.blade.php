@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3 class="mb-4">Dashboard Kasir</h3>

    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Penjualan Hari Ini</h6>
                    <h3>Rp {{ number_format($totalPenjualanKasirHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Jumlah Transaksi Hari Ini</h6>
                    <h3>{{ $totalTransaksiKasirHariIni }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
