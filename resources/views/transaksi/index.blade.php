@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Transaksi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">
        + Tambah Transaksi
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $key => $trx)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $trx->tanggal }}</td>
                            <td>{{ $trx->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('transaksi.show', $trx->id_transaksi) }}" class="link-primary" style="text-decoration:none;">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $transaksis->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
