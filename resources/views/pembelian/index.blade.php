@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Pembelian</h3>
    <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">+ Tambah Pembelian</a>

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
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $pembelian->id_pembelian }}">
                        Lihat
                    </button>
                </td>
            </tr>

            <!-- Modal Detail -->
            <div class="modal fade" id="detail{{ $pembelian->id_pembelian }}" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Detail Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Bahan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian->details as $detail)
                                <tr>
                                    <td>{{ $detail->bahan->nama_bahan }}</td>
                                    <td>{{ $detail->jumlah }} {{ $detail->bahan->satuan }}</td>
                                    <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
