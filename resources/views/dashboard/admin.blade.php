@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Selamat Datang, Admin</h3>
    <div class="row text-">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Penjualan Hari ini</h6>
                    <h3>Rp{{number_format($totalPenjualanHariIni,0,',','.')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Pembelian Bulan Ini</h6>
                    <h3>Rp{{number_format($totalPembelianBulanIni,0,',','.')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Penjualan Bulan Ini</h6>
                    <h3>Rp{{number_format($totalTransaksiBulanIni,0,',','.')}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection