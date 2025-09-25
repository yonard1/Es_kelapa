<div class="modal fade" id="editModal{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-t">Edit User</div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.update', $u->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama User</label>
                        <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $u->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="hak">Hak</label>
                        <select class="form-control" name="hak" id="hak" required>
                            <option value="admin" {{ $u->hak == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ $u->hak == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
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