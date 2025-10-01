<div class="modal fade" id="editModal{{ $products->id_produk }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('product.update', $products->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" value="{{ $products->nama_produk }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" step="0.01" name="harga" value="{{ $products->harga }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Foto</label>
                        @if($products -> foto)
                            <br>
                            <img src="{{asset('upload/produk/'.$products->foto)}}" width="100" class="mb-2">
                        @endif
                        <input type="file" name="foto" value="{{ $products->foto }}" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
