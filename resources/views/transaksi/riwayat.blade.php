@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-center">Riwayat Transaksi Saya</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trx->tanggal}}</td>
                <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('transaksi.show', $trx->id_transaksi) }}" class="btn btn-info">Lihat</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
