<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembelian</title>
    <style>
        /* Atur ukuran halaman untuk PDF */
        @page {
            size: 58mm auto;  /* Ukuran kertas 58mm x tinggi otomatis */
            margin: 0;         /* Hapus margin untuk mengoptimalkan ruang */
        }

        body {
            font-family: 'Courier New', monospace;
            width: 58mm;  /* Lebar kertas struk */
            margin: 0;    /* Menghilangkan margin luar */
            padding: 0;   /* Menghilangkan padding di body */
            font-size: 10px;  /* Ukuran font yang pas */
            text-align: center;  /* Pastikan konten terpusat */
        }

        h3, p {
            margin: 2px 0; /* Margin kecil antar elemen */
        }

        table {
            width: 100%;  /* Lebar tabel sesuai dengan lebar kertas */
            border-collapse: collapse;  /* Menghilangkan jarak antar border */
            padding: 0;
            margin-top: 5px;
        }

        th, td {
            text-align: left;
            padding: 3px 0;  /* Padding kecil agar tidak terlalu rapat */
            font-size: 9px;  /* Ukuran font kecil untuk tabel */
        }

        th {
            text-align: center;  /* Header tabel berada di tengah */
        }

        td {
            text-align: right;  /* Angka diratakan ke kanan */
        }

        .total {
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 3px;
        }

        .footer {
            text-align: center;
            margin-top: 5px;
            font-size: 9px;
        }

        /* Media print (Cetak ke PDF) */
        @media print {
            body {
                width: 58mm;  /* Ukuran kertas struk */
                margin: 0;
                padding: 0;
            }

            .btn {
                display: none;  /* Menyembunyikan tombol saat print */
            }

            /* Pastikan tidak ada ruang kosong yang terlalu besar */
            html, body {
                height: 100%;
            }

            .container {
                margin: 0;
                padding: 0;
            }

            /* Mengatur cetakan PDF supaya konten berada di tengah */
            @page {
                size: 58mm auto; 
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <h3>Es Kelapa Segar</h3>
    <p>Jl. Kelapa Muda No. 17</p>
    <p>Telp: 0812-3456-7890</p>
    <hr>
    <p><b>Tanggal:</b> {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>
    <p><b>Kasir:</b> {{ $transaksi->user->name ?? '-' }}</p>
    <hr>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Sub</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->details as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><b>Total:</b> Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
        <p><b>Bayar:</b> Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
        <p><b>Kembali:</b> Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Terima kasih sudah membeli!</p>
        <p>~ Es Kelapa Segar ~</p>
    </div>
</body>
</html>
