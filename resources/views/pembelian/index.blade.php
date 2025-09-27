@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Data Pembelian</h3>
    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreatePembelian">Tambah Pembelian</a>
    @include('pembelian.modal_create')
    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Bahan Baru</button>
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
            <!-- Detail Modal (letakkan di dalam foreach agar tiap modal punya id unik) -->
            <div class="modal fade" id="detail{{ $pembelian->id_pembelian }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Pembelian #{{ $pembelian->id_pembelian }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Tanggal:</strong> {{ $pembelian->tanggal }} <br>
                            <strong>Petugas:</strong> {{ $pembelian->user->name ?? '-' }}</p>

                            <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($pembelian->details as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->material->nama_bahan ?? '—' }}</td>
                                    <td>{{ $detail->jumlah }} {{ $detail->material->satuan ?? '' }}</td>
                                    <td>Rp {{ number_format($detail->harga,0,',','.') }}</td>
                                    <td>Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center">Tidak ada detail.</td></tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total</th>
                                    <th>Rp {{ number_format($pembelian->total,0,',','.') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection