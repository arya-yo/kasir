<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Tambah Pelanggan</h3>
    <a href="<?php echo site_url('pelanggan'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo site_url('pelanggan/store'); ?>">
    <div class="mb-3">
        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
    </div>
    
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
    </div>
    
    <div class="mb-3">
        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
        <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon">
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan
    </button>
    <a href="<?php echo site_url('pelanggan'); ?>" class="btn btn-secondary">Batal</a>
</form>

