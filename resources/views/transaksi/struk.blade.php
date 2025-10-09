<!DOCTYPE html>
<html>
    <head>
        <title>Struk Pembelian</title>
        <style>
            body {
                font-family: 'Courier New', monospace;
                width: 280px;
                margin: 0 auto;
                font-size: 13px;
            }
            h3, p { text-align: center; margin: 4px 0; }
            table { width: 100%; border-collapse: collapse; margin-top: 5px; }
            th, td { text-align: left; padding: 2px 0; }
            .total { border-top: 1px dashed #000; margin-top: 5px; padding-top: 5px; }
            .footer { text-align: center; margin-top: 10px; font-size: 12px; }
            @media print {
                @page {
                    size: 58mm auto; /* atau 80mm untuk printer lebih lebar */
                    margin: 0;
                }

                body {
                    width: 58mm;
                    font-family: 'Courier New', monospace;
                    font-size: 12px;
                    margin: 0 auto;
                }

                .btn {
                    display: none; /* Sembunyikan tombol cetak saat print */
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
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p><b>Total:</b> Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</p>
            <p><b>Bayar:</b> Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
            <p><b>Kembali:</b> Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
        </div>

        <div class="footer">
            <p>Terima kasih sudah membeli!</p>
            <p>~ Es Kelapa Segar ~</p>
        </div>

        
    </body>
</html>
