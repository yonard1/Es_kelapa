@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Transaksi</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <h5>Produk</h5>
        <table class="table table-bordered" id="produkTable">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="produk_id[]" class="form-select produkSelect" required>
                            <option value="">-- pilih produk --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga }}">
                                    {{ $p->nama_produk }} - Rp {{ number_format($p->harga,0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="jumlah[]" class="form-control qtyInput" min="1" value="1" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="addRow" class="btn btn-secondary btn-sm">+ Tambah Produk</button>

        <hr>
        <div class="mb-3">
            <label>Total Bayar:</label>
            <input type="text" id="total" name="total" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Uang Bayar:</label>
            <input type="number" id="bayar" name="bayar" class="form-control" oninput="hitungKembalian()" required>
        </div>

        <div class="mb-3">
            <label>Kembalian:</label>
            <input type="text" id="kembalian" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Simpan & Cetak Struk</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
document.getElementById('addRow').addEventListener('click', function() {
    let tableBody = document.querySelector('#produkTable tbody');
    let newRow = `
        <tr>
            <td>
                <select name="produk_id[]" class="form-select produkSelect" required>
                    <option value="">-- pilih produk --</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga }}">
                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga,0,',','.') }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="jumlah[]" class="form-control qtyInput" min="1" value="1" required></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
        </tr>
    `;
    tableBody.insertAdjacentHTML('beforeend', newRow);
    updateTotal();
});

// Hapus row
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
        updateTotal();
    }
});

// Hitung total dan kembalian otomatis
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('produkSelect') || e.target.classList.contains('qtyInput')) {
        updateTotal();
    }
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('#produkTable tbody tr').forEach(row => {
        let select = row.querySelector('.produkSelect');
        let qty = parseFloat(row.querySelector('.qtyInput').value) || 0;
        let harga = parseFloat(select.selectedOptions[0]?.getAttribute('data-harga')) || 0;
        total += harga * qty;
    });
    document.getElementById('total').value = total;
    hitungKembalian();
}

function hitungKembalian() {
    let total = parseFloat(document.getElementById('total').value || 0);
    let bayar = parseFloat(document.getElementById('bayar').value || 0);
    let kembali = bayar - total;
    document.getElementById('kembalian').value = kembali > 0 ? kembali : 0;
}
</script>
@endsection
