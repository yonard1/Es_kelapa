@extends('layouts.app')
@section('content')

<div class="container mt-4">
    <h2 class="mb-3 text-center">Laporan Penjualan & Pembelian</h2>

    {{-- Filter laporan --}}
    <form action="{{ route('laporan.index') }}" method="GET" class="mb-4 d-flex flex-wrap justify-content-center align-items-end gap-2">

        {{-- Filter tahun --}}
        <div>
            <label for="tahun" class="form-label fw-semibold text-secondary">Tahun</label>
            <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                @for ($i = date('Y'); $i >= 2020; $i--)
                    <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Filter tanggal mulai --}}
        <div>
            <label for="tanggal_mulai" class="form-label fw-semibold text-secondary">Dari</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
        </div>

        {{-- Filter tanggal selesai --}}
        <div>
            <label for="tanggal_selesai" class="form-label fw-semibold text-secondary">Sampai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
        </div>

        <div>
            <button type="submit" class="btn btn-success px-4">🔍 Tampilkan</button>
        </div>
    </form>

    {{-- Tabel Penjualan --}}
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

    {{-- Tabel Pembelian --}}
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
                            <th>Petugas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelians as $p)
                            <tr>
                                <td>{{ $p->tanggal }}</td>
                                <td>{{ $p->user->name ?? 'Tidak diketahui' }}</td>
                                <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Ringkasan Laporan</h5>
        </div>
        <div class="card-body text-center">
            <p><strong>Total Penjualan:</strong> Rp {{ number_format($total_penjualan, 0, ',', '.') }}</p>
            <p><strong>Total Pembelian:</strong> Rp {{ number_format($total_pembelian, 0, ',', '.') }}</p>

            @if($keuntungan > 0)
                <p class="text-success"><strong>Keuntungan:</strong> Rp {{ number_format($keuntungan, 0, ',', '.') }}</p>
            @elseif($keuntungan < 0)
                <p class="text-danger"><strong>Kerugian:</strong> Rp {{ number_format(abs($keuntungan), 0, ',', '.') }}</p>
            @else
                <p><strong>Seimbang:</strong> Tidak ada untung/rugi</p>
            @endif
        </div>
    </div>
</div>

@endsection
