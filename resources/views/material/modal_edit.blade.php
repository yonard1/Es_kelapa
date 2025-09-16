<div class="modal fade" id="editModal{{ $m->id_bahan }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('material.update', ['material' => $m->id_bahan]) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                <h5 class="modal-title">Edit Bahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Bahan</label>
                    <input type="text" name="nama_bahan" value="{{ $m->nama_bahan }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Satuan</label>
                    <input type="text" name="satuan" value="{{ $m->satuan }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ $m->stok }}" class="form-control" required>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
