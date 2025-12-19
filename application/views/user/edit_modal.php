<form id="editUserForm">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->Username; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru">
    </div>
    
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="">Pilih Role</option>
            <option value="admin" <?php echo $user->Role == 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="petugas" <?php echo $user->Role == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
        </select>
    </div>
    
    <div class="alert alert-info" role="alert">
        <small><i class="fas fa-info-circle"></i> Klik tombol Simpan untuk menyimpan perubahan</small>
    </div>
</form>

<script>
    let editUserID = <?php echo $user->UserID; ?>;
</script>
