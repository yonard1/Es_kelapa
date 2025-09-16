@extends('layouts.app')
@section('title', 'CRUD Bahan Baku')
@section('content')

<div class="container">
    <h2>Data Bahan</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Bahan</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Bahan</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $m)
            <tr>
                <td>{{ $m->id_bahan }}</td>
                <td>{{ $m->nama_bahan }}</td>
                <td>{{ $m->satuan }}</td>
                <td>{{ $m->stok }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $m->id_bahan }}">Edit</button>
                    <form action="{{ route('material.destroy', $m->id_bahan) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>

            {{-- Include Modal Edit per bahan --}}
            @include('material.modal_edit', ['m' => $m])
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Create --}}
@include('material.modal_create')
@endsection
