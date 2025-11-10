<!-- resources/views/laporan/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Laporan ({{ ucfirst($filter) }})</h3>

    <form method="GET" class="mb-3 d-flex align-items-center gap-2">
        <select name="filter" class="form-select w-auto">
            <option value="harian" {{ $filter == 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="mingguan" {{ $filter == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
            <option value="bulanan" {{ $filter == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
        </select>

        {{-- Filter Bulan dan Tahun untuk laporan bulanan --}}
        @if($filter == 'bulanan')
            <select name="bulan" class="form-select w-auto">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" class="form-select w-auto">
                @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        @endif

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('laporan.download', ['filter' => $filter, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-danger">Download PDF</a>
    </div>

    {{-- Data Penjualan --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Data Penjualan</h5>
        </div>
        <div class="card-body">
            @if($transaksis->isEmpty())
                <p class="text-center text-muted">Belum ada data penjualan untuk periode ini.</p>
            @else
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-success">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $t)
                            <tr>
                                <td>{{ $t->tanggal }}</td>
                                <td>{{ $t->user->name ?? 'Tidak diketahui' }}</td>
                                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Data Pembelian --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Data Pembelian</h5>
        </div>
        <div class="card-body">
            @if($pembelians->isEmpty())
                <p class="text-center text-muted">Belum ada data pembelian untuk periode ini.</p>
            @else
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-warning">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pemasok</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelians as $p)
                            <tr>
                                <td>{{ $p->tanggal }}</td>
                                <td>{{ $p->supplier->name ?? 'Tidak diketahui' }}</td>
                                <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Total & Keuntungan --}}
    <div class="alert alert-info">
        <h5>Total Penjualan: Rp {{ number_format($total_penjualan, 0, ',', '.') }}</h5>
        <h5>Total Pembelian: Rp {{ number_format($total_pembelian, 0, ',', '.') }}</h5>
        <h5>Keuntungan: Rp {{ number_format($keuntungan, 0, ',', '.') }}</h5>
    </div>
</div>
@endsection
