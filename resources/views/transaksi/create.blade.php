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
            <input type="date" name="tanggal" class="form-control" required>
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
                        <select name="produk_id[]" class="form-select" required>
                            <option value="">-- pilih produk --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id_produk }}">
                                    {{ $p->nama_produk }} - Rp {{ number_format($p->harga,0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control" min="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="addRow" class="btn btn-secondary btn-sm">+ Tambah Produk</button>
        <br><br>
        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
document.getElementById('addRow').addEventListener('click', function() {
    let tableBody = document.querySelector('#produkTable tbody');
    let newRow = `
        <tr>
            <td>
                <select name="produk_id[]" class="form-select" required>
                    <option value="">-- pilih produk --</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id_produk }}">
                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga,0,',','.') }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="jumlah[]" class="form-control" min="1" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
            </td>
        </tr>
    `;
    tableBody.insertAdjacentHTML('beforeend', newRow);
});

// Hapus row produk
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endsection
