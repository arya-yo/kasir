<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Edit User</h3>
    <a href="<?php echo site_url('user'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo site_url('user/update/' . $user->UserID); ?>">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" 
               value="<?php echo $user->Username; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="admin" <?php echo $user->Role == 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="petugas" <?php echo $user->Role == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Update
    </button>
    <a href="<?php echo site_url('user'); ?>" class="btn btn-secondary">Batal</a>
</form>

