<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Transaksi Penjualan</h3>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Search Produk -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="<?php echo site_url('penjualan'); ?>" class="row g-3" id="searchForm">
            <div class="col-md-10">
                <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari produk..." 
                       value="<?php echo isset($search) ? $search : ''; ?>">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fas fa-search"></i> Cari
                </button>
                <?php if (isset($search) && !empty($search)): ?>
                <button type="button" class="btn btn-outline-secondary" onclick="resetSearch()" title="Reset Filter">
                    <i class="fas fa-times"></i>
                </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
    function resetSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchForm').submit();
    }
</script>

<form method="post" action="<?php echo site_url('penjualan/proses'); ?>" id="formPenjualan">
    <h5 class="mb-3">Pilih Produk dan Jumlah</h5>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th width="50">Pilih</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th width="200">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produks)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada produk tersedia</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produks as $index => $produk): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="produk_id[]" value="<?php echo $produk->ProdukID; ?>" 
                                   class="produk-checkbox" data-harga="<?php echo $produk->Harga; ?>"
                                   data-stok="<?php echo $produk->Stok; ?>" data-index="<?php echo $index; ?>">
                        </td>
                        <td><?php echo $produk->NamaProduk; ?></td>
                        <td>Rp <?php echo number_format($produk->Harga, 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge <?php echo $produk->Stok > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $produk->Stok; ?>
                            </span>
                        </td>
                        <td>
                            <div class="input-group" style="width: 150px;">
                                <button type="button" class="btn btn-outline-secondary btn-minus" 
                                        data-index="<?php echo $index; ?>" disabled>-</button>
                                <input type="number" name="jumlah[]" class="form-control jumlah-input text-center" 
                                       id="jumlah_<?php echo $index; ?>"
                                       min="1" max="<?php echo $produk->Stok; ?>" 
                                       value="1" disabled readonly>
                                <button type="button" class="btn btn-outline-secondary btn-plus" 
                                        data-index="<?php echo $index; ?>" disabled>+</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pagination) && !empty($pagination)): ?>
    <div class="d-flex justify-content-center mt-3">
        <?php echo $pagination; ?>
    </div>
    <?php endif; ?>

    <div class="mt-4">
        <h5>Total: <span id="totalHarga">Rp 0</span></h5>
    </div>

    <div class="mt-4">
        <button type="button" class="btn btn-primary btn-lg" id="btnProsesTransaksi" disabled>
            <i class="fas fa-shopping-cart"></i> Proses Transaksi
        </button>
        <button type="reset" class="btn btn-secondary btn-lg">Reset</button>
    </div>
</form>

<!-- Modal Data Pelanggan -->
<div class="modal fade" id="modalPelanggan" tabindex="-1" aria-labelledby="modalPelangganLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPelangganLabel">Data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPelanggan">
                    <div class="mb-3">
                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanTransaksi">
                    <i class="fas fa-save"></i> Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.produk-checkbox');
    const jumlahInputs = document.querySelectorAll('.jumlah-input');
    const btnMinus = document.querySelectorAll('.btn-minus');
    const btnPlus = document.querySelectorAll('.btn-plus');
    const totalHargaSpan = document.getElementById('totalHarga');
    const btnProsesTransaksi = document.getElementById('btnProsesTransaksi');
    const modalPelanggan = new bootstrap.Modal(document.getElementById('modalPelanggan'));
    const formPenjualan = document.getElementById('formPenjualan');

    function updateTotal() {
        let total = 0;
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const index = parseInt(checkbox.dataset.index);
                const harga = parseFloat(checkbox.dataset.harga);
                const jumlah = parseInt(document.getElementById('jumlah_' + index).value) || 0;
                total += harga * jumlah;
            }
        });
        totalHargaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        // Enable/disable tombol proses transaksi
        const hasSelected = Array.from(checkboxes).some(cb => cb.checked);
        btnProsesTransaksi.disabled = !hasSelected || total === 0;
    }

    // Handle checkbox change
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const index = parseInt(this.dataset.index);
            const jumlahInput = document.getElementById('jumlah_' + index);
            const minusBtn = btnMinus[index];
            const plusBtn = btnPlus[index];
            const stok = parseInt(this.dataset.stok);
            
            if (this.checked) {
                jumlahInput.disabled = false;
                jumlahInput.readOnly = false;
                minusBtn.disabled = false;
                plusBtn.disabled = false;
                jumlahInput.value = 1;
                jumlahInput.max = stok;
            } else {
                jumlahInput.disabled = true;
                jumlahInput.readOnly = true;
                minusBtn.disabled = true;
                plusBtn.disabled = true;
                jumlahInput.value = '';
            }
            updateTotal();
        });
    });

    // Handle plus button
    btnPlus.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const jumlahInput = document.getElementById('jumlah_' + index);
            const max = parseInt(jumlahInput.max);
            const current = parseInt(jumlahInput.value) || 0;
            if (current < max) {
                jumlahInput.value = current + 1;
                updateTotal();
            }
        });
    });

    // Handle minus button
    btnMinus.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const jumlahInput = document.getElementById('jumlah_' + index);
            const current = parseInt(jumlahInput.value) || 1;
            if (current > 1) {
                jumlahInput.value = current - 1;
                updateTotal();
            }
        });
    });

    // Handle manual input
    jumlahInputs.forEach(input => {
        input.addEventListener('input', function() {
            const max = parseInt(this.max);
            const value = parseInt(this.value) || 0;
            if (value > max) {
                this.value = max;
            }
            if (value < 1) {
                this.value = 1;
            }
            updateTotal();
        });
    });

    // Handle proses transaksi button
    btnProsesTransaksi.addEventListener('click', function() {
        // Validasi minimal satu produk dipilih
        const hasSelected = Array.from(checkboxes).some(cb => cb.checked);
        if (!hasSelected) {
            alert('Pilih minimal satu produk!');
            return;
        }
        
        // Tampilkan modal pelanggan
        modalPelanggan.show();
    });

    // Handle simpan transaksi
    document.getElementById('btnSimpanTransaksi').addEventListener('click', function() {
        const namaPelanggan = document.getElementById('nama_pelanggan').value.trim();
        
        if (!namaPelanggan) {
            alert('Nama pelanggan harus diisi!');
            return;
        }
        
        // Tambahkan hidden input untuk data pelanggan
        let inputNama = document.createElement('input');
        inputNama.type = 'hidden';
        inputNama.name = 'nama_pelanggan';
        inputNama.value = namaPelanggan;
        formPenjualan.appendChild(inputNama);
        
        let inputAlamat = document.createElement('input');
        inputAlamat.type = 'hidden';
        inputAlamat.name = 'alamat';
        inputAlamat.value = document.getElementById('alamat').value;
        formPenjualan.appendChild(inputAlamat);
        
        let inputTelepon = document.createElement('input');
        inputTelepon.type = 'hidden';
        inputTelepon.name = 'nomor_telepon';
        inputTelepon.value = document.getElementById('nomor_telepon').value;
        formPenjualan.appendChild(inputTelepon);
        
        // Submit form
        formPenjualan.submit();
    });

    // Reset modal saat ditutup
    document.getElementById('modalPelanggan').addEventListener('hidden.bs.modal', function() {
        document.getElementById('formPelanggan').reset();
    });

    // Initial update
    updateTotal();
});
</script>
