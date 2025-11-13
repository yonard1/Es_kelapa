@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Transaksi</h3>

    @if (session('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
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
        <a href="{{ route('transaksi.create') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#produkTable tbody');
    const totalInput = document.getElementById('total');
    const bayarInput = document.getElementById('bayar');
    const kembalianInput = document.getElementById('kembalian');
    const form = document.querySelector('form');

    // Tombol tambah produk
    document.getElementById('addRow').addEventListener('click', function() {
        let newRow = document.createElement('tr');
        newRow.innerHTML = `
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
        `;
        tableBody.appendChild(newRow);
    });

    // Hapus produk
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
            updateTotal();
        }
    });

    // Hitung ulang total setiap kali produk/jumlah berubah
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('produkSelect') || e.target.classList.contains('qtyInput')) {
            validateDuplicateProduct();
            updateTotal();
        }
    });

    // Hitung kembalian saat input uang bayar berubah
    bayarInput.addEventListener('input', hitungKembalian);

    // === VALIDASI SUBMIT ===
    form.addEventListener('submit', function(event) {
        const total = parseFloat(totalInput.value || 0);
        const bayar = parseFloat(bayarInput.value || 0);

        if (bayar < total) {
            event.preventDefault();
            alert('⚠️ Uang yang dibayarkan kurang dari total yang harus dibayar!');
        }
    });

    // === Fungsi bantu ===
    function validateDuplicateProduct() {
        let selects = document.querySelectorAll('.produkSelect');
        let values = [];

        for (let select of selects) {
            let val = select.value;
            if (val && values.includes(val)) {
                alert('Produk ini sudah ditambahkan! Silakan ubah jumlahnya saja.');
                select.value = '';
                updateTotal();
                return false;
            }
            if (val) values.push(val);
        }
        return true;
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#produkTable tbody tr').forEach(row => {
            let select = row.querySelector('.produkSelect');
            let qty = parseFloat(row.querySelector('.qtyInput').value) || 0;
            let harga = parseFloat(select.selectedOptions[0]?.getAttribute('data-harga')) || 0;
            total += harga * qty;
        });
        totalInput.value = total.toFixed(0);
        hitungKembalian(); // biar kembalian ikut update
    }

    function hitungKembalian() {
        let total = parseFloat(totalInput.value || 0);
        let bayar = parseFloat(bayarInput.value || 0);
        let kembali = bayar - total;
        kembalianInput.value = (kembali >= 0 ? kembali : 0).toFixed(0);
    }
});
</script>
@endsection
