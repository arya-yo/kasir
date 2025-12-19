<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Selamat Datang, <?php echo $user['username']; ?>!</h2>
        
        <?php if ($user['role'] == 'admin'): ?>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users"></i> Total User</h5>
                            <h2 class="card-text"><?php echo isset($total_user) ? $total_user : '0'; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-box"></i> Total Produk</h5>
                            <h2 class="card-text"><?php echo isset($total_produk) ? $total_produk : '0'; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Total Penjualan</h5>
                            <h2 class="card-text"><?php echo isset($total_penjualan) ? $total_penjualan : '0'; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Selamat Bekerja!</h5>
                <p>Gunakan menu di sidebar untuk melakukan transaksi penjualan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

