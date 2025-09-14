@extends('layouts.app')
@section('title','CRUD Produk')
@section('content')
<div class="container">
    <h2>Data Produk</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Produk</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        @foreach($products as $p)
        <tr>
            <td>{{ $p->id_produk }}</td>
            <td>{{ $p->nama_produk }}</td>
            <td>Rp. {{ number_format($p->harga, 0, ',', '.') }}</td>
            <td>{{ $p->stok }}</td>
            <td>
                <!-- Tombol Edit -->
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id_produk }}">Edit</button>

                <!-- Form Hapus -->
                <form action="{{ route('product.destroy',$p->id_produk) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>

        <!-- Include Modal Edit -->
        @include('product.modal_edit', ['products' => $p])
        @endforeach
    </table>
</div>

<!-- Include Modal Create -->
@include('product.modal_create')

@endsection
