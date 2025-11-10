<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" step="0.01" name="harga" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">

                        <!-- Tempat menampilkan preview -->
                        <div class="mt-2 text-center">
                            <img id="previewImage" src="#" alt="Preview Gambar" 
                                 style="display:none; max-width: 150px; border: 1px solid #ccc; border-radius: 5px; padding: 5px;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script preview gambar -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById('fotoInput');
    const preview = document.getElementById('previewImage');

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            preview.style.display = 'none';
        }
    });
});
</script>
