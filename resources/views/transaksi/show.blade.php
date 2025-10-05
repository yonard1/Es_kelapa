@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Detail Transaksi</h3>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>
            <p><strong>Kasir:</strong> {{ $transaksi->user->name ?? '-' }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
        </div>
    </div>

    <h5>Daftar Produk</h5>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->details as $key => $detail)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td>Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
