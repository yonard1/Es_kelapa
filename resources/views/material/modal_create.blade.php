<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('material.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Bahan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Bahan</label>
            <input type="text" name="nama_bahan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Foto</label>
              <input type="file" name="foto" id="fotoinput" class="form-control">
              <!-- Tempat menampilkan preview -->
              <div class="mt-2 text-center">
                  <img id="previewImage" src="#" alt="Preview Gambar" style="display:none; max-width: 150px; border: 1px solid #ccc; border-radius: 5px; padding: 5px;">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script preview gambar -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
      const input = document.getElementById('fotoinput');
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
              preview.src = '#';
              preview.style.display = 'none';
          }
      });
  });
</script>