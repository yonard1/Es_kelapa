<div class="modal fade" id="modalTambahProduksi" tabindex="-1" aria-labelledby="modalTambahProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold" id="modalTambahProduksiLabel">Tambah Produksi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('produksi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <select name="id_produk" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produk as $p)
                                <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Produksi</label>
                            <input type="date" name="tanggal_produksi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Dibuat</label>
                            <input type="number" name="jumlah_dibuat" class="form-control" placeholder="Contoh: 20" required>
                        </div>
                    </div>

                    <hr>

                    <label class="form-label mt-2">Bahan yang Digunakan</label>
                    <div id="bahan-container">
                        <div class="row g-2 bahan-row align-items-center mb-2">
                            <div class="col-md-4">
                                <select name="bahan[]" class="form-select" required>
                                    <option value="">-- Pilih Bahan --</option>
                                    @foreach ($bahan as $b)
                                        <option value="{{ $b->id_bahan }}">{{ $b->nama_bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="jumlah_dipakai[]" class="form-control" placeholder="Jumlah dipakai" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="satuan[]" class="form-control" placeholder="Satuan (opsional)">
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-bahan">&times;</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-bahan" class="btn btn-outline-primary btn-sm mt-1">+ Tambah Baris</button>

                    <div class="mt-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Opsional..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Produksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 🧩 JS Dinamis + Transisi Lembut --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-bahan').addEventListener('click', function(){
        const container = document.getElementById('bahan-container');
        const row = container.querySelector('.bahan-row').cloneNode(true);
        row.querySelectorAll('input').forEach(i => i.value = '');
        container.appendChild(row);

        row.style.opacity = 0;
        setTimeout(() => row.style.transition = 'opacity 0.4s ease', 10);
        setTimeout(() => row.style.opacity = 1, 30);
    });

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-bahan')){
            const row = e.target.closest('.bahan-row');
            row.style.transition = 'opacity 0.3s ease';
            row.style.opacity = 0;
            setTimeout(() => row.remove(), 300);
        }
    });
});
</script>
