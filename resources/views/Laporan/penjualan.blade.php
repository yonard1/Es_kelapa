@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Laporan ({{ ucfirst($filter)}}) </h3>

    <form method="GET" class="mb-3">
        <select name="filter" class="form-select w-auto d-inline">
            <option value="harian" {{ $filter=='harian'?'selected':'' }}>Harian</option>
            <option value="mingguan" {{ $filter=='mingguan'?'selected':'' }}>Mingguan</option>
            <option value="bulanan" {{ $filter=='bulanan'?'selected':'' }}>Bulanan</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Nama Kasir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $i => $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item -> tanggal}}</td>
                    <td>{{$item -> product -> nama_produk}}</td>
                    <td>{{$item->qty}}</td>
                    <td>Rp.{{number_format($item->harga,0,',','.')}}</td>
                    <td>Rp.{{number_format($item->qty * $item->harga,0,',', '.')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h5>Total Penjualan: Rp {{ number_format($totalPenjualan,0,',','.')}}</h5>
</div>

@endsection