<div class="row mb-3">
    <div class="col-md-6">
        <h6 class="text-muted">Tanggal</h6>
        <p><strong><?php echo date('d/m/Y', strtotime($penjualan->TanggalPenjualan)); ?></strong></p>
    </div>
    <div class="col-md-6">
        <h6 class="text-muted">Total Harga</h6>
        <p><strong class="text-success fs-5">Rp <?php echo number_format($penjualan->TotalHarga, 0, ',', '.'); ?></strong></p>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <h6 class="text-muted">Pelanggan</h6>
        <p><strong><?php echo $penjualan->NamaPelanggan ? $penjualan->NamaPelanggan : 'Umum'; ?></strong></p>
    </div>
    <div class="col-md-6">
        <h6 class="text-muted">Telepon</h6>
        <p><strong><?php echo $penjualan->NomorTelepon ? $penjualan->NomorTelepon : '-'; ?></strong></p>
    </div>
</div>

<?php if ($penjualan->Alamat): ?>
<div class="row mb-3">
    <div class="col-12">
        <h6 class="text-muted">Alamat</h6>
        <p><strong><?php echo $penjualan->Alamat; ?></strong></p>
    </div>
</div>
<?php endif; ?>

<hr class="my-3">

<h6 class="mb-3">Detail Barang</h6>
<div class="table-responsive">
    <table class="table table-sm table-striped">
        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Jumlah</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($details)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada detail</td>
                </tr>
            <?php else: ?>
                <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?php echo $detail->NamaProduk; ?></td>
                    <td class="text-center">Rp <?php echo number_format($detail->Harga, 0, ',', '.'); ?></td>
                    <td class="text-center"><?php echo $detail->JumlahProduk; ?></td>
                    <td class="text-end">Rp <?php echo number_format($detail->Subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

