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

        <h5>Daftar Bahan</h5>
        <table class="table" id="bahanTable">
            <thead>
                <tr>
                    <th>Bahan</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th><button type="button" class="btn btn-sm btn-success" id="addRow">+</button></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="bahan[0][id_bahan]" class="form-control">
                            @foreach($bahans as $bahan)
                                <option value="{{ $bahan->id_bahan }}">{{ $bahan->nama_bahan }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="bahan[0][jumlah]" class="form-control"></td>
                    <td><input type="number" name="bahan[0][harga]" class="form-control"></td>
                    <td><button type="button" class="btn btn-sm btn-danger removeRow">-</button></td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    let row = 1;
    document.getElementById('addRow').addEventListener('click', function() {
        let table = document.querySelector('#bahanTable tbody');
        let newRow = table.insertRow();
        newRow.innerHTML = `
            <td>
                <select name="bahan[${row}][id_bahan]" class="form-control">
                    @foreach($bahans as $bahan)
                        <option value="{{ $bahan->id_bahan }}">{{ $bahan->nama_bahan }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="bahan[${row}][jumlah]" class="form-control"></td>
            <td><input type="number" name="bahan[${row}][harga]" class="form-control"></td>
            <td><button type="button" class="btn btn-sm btn-danger removeRow">-</button></td>
        `;
        row++;
    });

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('removeRow')){
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection
