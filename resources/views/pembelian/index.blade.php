@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Data Pembelian</h3>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreatePembelian">Tambah Pembelian</button>
        @include('pembelian.modal_create')
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Bahan Baru</button>
        @include('material.modal_create')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Petugas</th>
                <th>Total</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelians as $pembelian)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembelian->tanggal }}</td>
                <td>{{ $pembelian->user->name ?? '-' }}</td>
                <td>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                <td>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $pembelian->id_pembelian }}">Lihat</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @foreach($pembelians as $pembelian)
        @include('pembelian.modal_detail', ['pembelian' => $pembelian])
    @endforeach
</div>
@endsection