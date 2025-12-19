<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Tambah Produk</h3>
    <a href="<?php echo site_url('produk'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo site_url('produk/store'); ?>">
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
    </div>
    
    <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" required>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan
    </button>
    <a href="<?php echo site_url('produk'); ?>" class="btn btn-secondary">Batal</a>
</form>

