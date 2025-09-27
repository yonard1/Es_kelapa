@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Pembelian</h3>
    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        {{-- isi bahan sama seperti modal --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
