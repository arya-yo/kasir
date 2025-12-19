<div class="row">
    <div class="col-12">
        <h6 class="text-muted">Nama Produk</h6>
        <p><strong><?php echo $produk->NamaProduk; ?></strong></p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h6 class="text-muted">Harga</h6>
        <p><strong class="text-success">Rp <?php echo number_format($produk->Harga, 0, ',', '.'); ?></strong></p>
    </div>
    <div class="col-md-6">
        <h6 class="text-muted">Stok</h6>
        <p>
            <span class="badge <?php echo $produk->Stok > 0 ? 'bg-success' : 'bg-danger'; ?>">
                <?php echo $produk->Stok; ?>
            </span>
        </p>
    </div>
</div>
