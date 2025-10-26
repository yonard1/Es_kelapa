@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">📦 Data Produksi</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProduksi">
            + Tambah Produksi
        </button>
    </div>

    {{-- ✅ Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- 📋 Tabel Produksi --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Tanggal</th>
                        <th>Jumlah Dibuat</th>
                        <th>Bahan Digunakan</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produksi as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->produk->nama_produk ?? '-' }}</td>
                            <td>{{ $p->tanggal_produksi }}</td>
                            <td>{{ $p->jumlah_dibuat }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach ($p->detail as $d)
                                        <li>{{ $d->bahan->nama_bahan ?? '-' }} - {{ $d->jumlah_dipakai }} {{ $d->satuan }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $p->catatan ?? '-' }}</td>
                            <td>
                                <form action="{{ route('produksi.destroy', $p->id_produksi) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($produksi->isEmpty())
                        <tr><td colspan="7" class="text-center text-muted">Belum ada data produksi.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $produksi->links() }}
    </div>
</div>

{{-- 🔹 Include Modal --}}
@include('produksi.modal_create')
@endsection
