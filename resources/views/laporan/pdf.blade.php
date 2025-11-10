<!-- resources/views/laporan/pdf.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ ucfirst($filter) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .text-center {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table, .th, .td {
            border: 1px solid black;
        }
        .th, .td {
            padding: 8px;
            text-align: left;
        }
        .alert {
            background-color: #f8f9fa;
            padding: 10px;
        }
    </style>
</head>
<body>

    <h3 class="text-center">Laporan {{ ucfirst($filter) }}</h3>

    {{-- Data Penjualan --}}
    <h4>Data Penjualan</h4>
    @if($transaksis->isEmpty())
        <p class="text-center">Belum ada data penjualan untuk periode ini.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th class="th">Tanggal</th>
                    <th class="th">Kasir</th>
                    <th class="th">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $t)
                    <tr>
                        <td class="td">{{ $t->tanggal }}</td>
                        <td class="td">{{ $t->user->name ?? 'Tidak diketahui' }}</td>
                        <td class="td">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Data Pembelian --}}
    <h4>Data Pembelian</h4>
    @if($pembelians->isEmpty())
        <p class="text-center">Belum ada data pembelian untuk periode ini.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th class="th">Tanggal</th>
                    <th class="th">Pemasok</th>
                    <th class="th">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelians as $p)
                    <tr>
                        <td class="td">{{ $p->tanggal }}</td>
                        <td class="td">{{ $p->supplier->name ?? 'Tidak diketahui' }}</td>
                        <td class="td">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Ringkasan --}}
    <div class="alert">
        <h4>Total Penjualan: Rp {{ number_format($total_penjualan, 0, ',', '.') }}</h4>
        <h4>Total Pembelian: Rp {{ number_format($total_pembelian, 0, ',', '.') }}</h4>
        <h4>Keuntungan: Rp {{ number_format($keuntungan, 0, ',', '.') }}</h4>
    </div>

</body>
</html>
