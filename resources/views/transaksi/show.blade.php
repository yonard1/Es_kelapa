@extends('layouts.app')

@section('content')
<style>
@media print {
    .btn, .modal { display: none !important; }
    body { background: #fff; }
}
</style>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Transaksi</h3>
        <button class="btn btn-success" id="btnPrint"
        onclick="window.open('{{ route('transaksi.cetak', $transaksi->id_transaksi) }}', '_blank')">
            🧾 Cetak Struk
        </button>
    </div>

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

    <a href="{{ $backUrl }}" class="btn btn-secondary mt-3">⬅️ Kembali</a>
</div>

{{-- Pop-up Cetak --}}
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3">
        <div class="modal-header">
            <h5 class="modal-title" id="printModalLabel">Cetak Struk</h5>
        </div>
        <div class="modal-body">
            <p>Apakah kamu ingin mencetak struk transaksi ini?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-success" id="confirmPrint">Ya, Cetak</button>
        </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const printBtn = document.getElementById('btnPrint');
    printBtn.addEventListener('click', function() {
        window.open('{{ route('transaksi.cetak', $transaksi->id_transaksi) }}', '_blank');
    });
});
</script>

@endsection
