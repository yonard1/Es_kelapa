@extends('layouts.app')
@section('title', 'User')
@section('content')

<div class="container">
    <h2>Data Pengguna</h2>
    <button class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Pengguna</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Hak</th>
            <th>Aksi</th>
        </tr>
        @foreach ($users as $u)
            <tr>
                <td>{{ $u -> id }}</td>
                <td>{{ $u -> name }}</td>
                <td>{{ $u -> username }}</td>
                <td>{{ $u -> hak }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $u -> id }}">
                        Edit
                    </button>
                    <form action="{{ route('users.destroy',$u->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @include('users.modal_edit', ['users' => $u])
        @endforeach
    </table>
</div>
@include ('users.modal_create', ['users' => $u])
@endsection
