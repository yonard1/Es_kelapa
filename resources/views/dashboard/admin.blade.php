@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Selamat Datang, Admin</h3>

    {{-- Filter Bulan --}}
    <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select name="bulan" class="form-select">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ (isset($bulan) && $bulan == $m) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            {{-- Dropdown Tahun --}}
            <div class="col-auto">
                <select name="tahun" class="form-select">
                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ (isset($tahun) && $tahun == $y) ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    {{-- Kartu Dashboard --}}
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Omzet Hari ini</h6>
                    <h3>Rp{{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>total Pembelian Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</h6>
                    <h3>Rp{{ number_format($totalPembelianBulanIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Omzet Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h6>
                    <h3>Rp{{ number_format($totalTransaksiBulanIni, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Laba Bulan ini</h6>
                    <h3>Rp{{ number_format($keuntungan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        @if ($stokHampirHabis->count() > 0)
            <div class="alert alert-warning">
                <h5>Peringatan : Stok Hampir Habis</h5>
                <ul>
                    @foreach ($stokHampirHabis as $bhn)
                        <li>{{ $bhn->nama_bahan }} : {{ $bhn->stok }} {{ $bhn->satuan }} Tersedia</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
