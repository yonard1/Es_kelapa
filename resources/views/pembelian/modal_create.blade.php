<div class="modal fade" id="modalCreatePembelian" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Tanggal Pembelian --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    {{-- Daftar Bahan --}}
                    <div id="bahan-container">
                        <div class="row g-2 align-items-end bahan-item">
                            <div class="col-md-3">
                                <label class="form-label">Bahan</label>
                                <select name="bahan[0][id_bahan]" class="form-select" required>
                                    <option value="">-- Pilih Bahan --</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id_bahan }}">{{ $material->nama_bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="bahan[0][jumlah]" class="form-control jumlah" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Harga PerPcs</label>
                                <input type="number" name="bahan[0][harga]" class="form-control harga" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="bahan[0][subtotal]" class="form-control subtotal" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Tambah Baris Bahan --}}
                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="tambahBarisBahan()">+ Tambah Bahan</button>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let index = 1;

    function tambahBarisBahan() {
        let container = document.getElementById('bahan-container');
        let item = document.querySelector('.bahan-item').cloneNode(true);

        // Reset nilai input
        item.querySelectorAll('input').forEach(input => input.value = '');
        item.querySelector('select').selectedIndex = 0;

        // Update nama input sesuai index
        item.querySelector('.jumlah').name = `bahan[${index}][jumlah]`;
        item.querySelector('.harga').name = `bahan[${index}][harga]`;
        item.querySelector('.subtotal').name = `bahan[${index}][subtotal]`;
        item.querySelector('select').name = `bahan[${index}][id_bahan]`;

        container.appendChild(item);
        index++;
    }

    // Hitung subtotal per baris
    document.addEventListener("input", function(e) {
        if (e.target.classList.contains("jumlah") || e.target.classList.contains("harga")) {
            let row = e.target.closest(".bahan-item");
            let jumlah = parseFloat(row.querySelector(".jumlah").value) || 0;
            let harga = parseFloat(row.querySelector(".harga").value) || 0;
            row.querySelector(".subtotal").value = jumlah * harga;
        }
    });
</script>
