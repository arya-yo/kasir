<form id="editProdukForm">
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $produk->NamaProduk; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $produk->Harga; ?>" min="1" required>
    </div>
    
    <div class="mb-3">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $produk->Stok; ?>" min="0" required>
    </div>
    
    <div class="alert alert-info" role="alert">
        <small><i class="fas fa-info-circle"></i> Klik tombol Simpan untuk menyimpan perubahan</small>
    </div>
</form>

<script>
    let editProdukID = <?php echo $produk->ProdukID; ?>;
</script>
