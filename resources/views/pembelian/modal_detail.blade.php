<!-- Modal Detail -->
<div class="modal fade" id="detail{{ $pembelian->id_pembelian }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pembelian #{{ $pembelian->id_pembelian }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Tanggal:</strong> {{ $pembelian->tanggal }} <br>
                <strong>Petugas:</strong> {{ $pembelian->user->name ?? '-' }}</p>

                <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Bahan</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($pembelian->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->bahan->nama_bahan ?? '—' }}</td>
                        <td>{{ $detail->jumlah }} {{ $detail->bahan->satuan ?? '' }}</td>
                        <td>Rp {{ number_format($detail->harga,0,',','.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada detail.</td></tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp {{ number_format($pembelian->total,0,',','.') }}</th>
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
