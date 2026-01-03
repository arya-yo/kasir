<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Transaksi Penjualan</h3>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 animate-fade-in flex justify-between items-center">
            <span><i class="fas fa-check-circle mr-2"></i> <?php echo $this->session->flashdata('success'); ?></span>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate-fade-in flex justify-between items-center">
            <span><i class="fas fa-exclamation-circle mr-2"></i> <?php echo $this->session->flashdata('error'); ?></span>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Search Produk -->
    <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
        <form method="get" action="<?php echo site_url('penjualan'); ?>" class="flex gap-2" id="searchForm">
            <input type="text" class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" name="search" id="searchInput" placeholder="Cari produk..." value="<?php echo isset($search) ? $search : ''; ?>">
            <button type="submit" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all duration-300">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
            <?php if (isset($search) && !empty($search)): ?>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-300" onclick="resetSearch()" title="Reset Filter">
                <i class="fas fa-times"></i>
            </button>
            <?php endif; ?>
        </form>
    </div>

<script>
    function resetSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchForm').submit();
    }
</script>

    <form method="post" action="<?php echo site_url('penjualan/proses'); ?>" id="formPenjualan">
        <h5 class="text-lg font-semibold mb-4 text-gray-800">Pilih Produk dan Jumlah</h5>
        
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left w-16">Pilih</th>
                        <th class="px-4 py-3 text-left">Nama Produk</th>
                        <th class="px-4 py-3 text-left">Harga</th>
                        <th class="px-4 py-3 text-left">Stok</th>
                        <th class="px-4 py-3 text-left w-48">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($produks)): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada produk tersedia</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produks as $index => $produk): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="produk_id[]" value="<?php echo $produk->ProdukID; ?>" 
                                       class="produk-checkbox w-4 h-4 text-blue-600 rounded focus:ring-blue-500" 
                                       data-harga="<?php echo $produk->Harga; ?>"
                                       data-stok="<?php echo $produk->Stok; ?>" data-index="<?php echo $index; ?>">
                            </td>
                            <td class="px-4 py-3 font-medium"><?php echo $produk->NamaProduk; ?></td>
                            <td class="px-4 py-3">Rp <?php echo number_format($produk->Harga, 0, ',', '.'); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold <?php echo $produk->Stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $produk->Stok; ?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center w-40">
                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-l-lg transition-colors duration-300 btn-minus disabled:opacity-50 disabled:cursor-not-allowed" data-index="<?php echo $index; ?>" disabled>-</button>
                                    <input type="number" name="jumlah[]" class="jumlah-input w-full px-2 py-2 text-center border-y border-gray-300 focus:outline-none disabled:bg-gray-100" 
                                           id="jumlah_<?php echo $index; ?>"
                                           min="1" max="<?php echo $produk->Stok; ?>" 
                                           value="1" disabled readonly>
                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-r-lg transition-colors duration-300 btn-plus disabled:opacity-50 disabled:cursor-not-allowed" data-index="<?php echo $index; ?>" disabled>+</button>
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
        <div class="flex justify-center mt-4">
            <?php echo $pagination; ?>
        </div>
        <?php endif; ?>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h5 class="text-lg font-semibold text-gray-800">Total: <span id="totalHarga" class="text-blue-600 text-2xl">Rp 0</span></h5>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="button" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed" id="btnProsesTransaksi" disabled>
                <i class="fas fa-shopping-cart mr-2"></i> Proses Transaksi
            </button>
            <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition-colors duration-300">Reset</button>
        </div>
    </form>

    <!-- Modal Data Pelanggan -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="modalPelanggan">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Data Pelanggan</h5>
                <button type="button" onclick="closePelangganModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5">
                <form id="formPelanggan">
                    <div class="mb-4">
                        <label for="nama_pelanggan" class="block mb-2 text-gray-700 font-medium text-sm">Nama Pelanggan <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" id="nama_pelanggan" name="nama_pelanggan" required>
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block mb-2 text-gray-700 font-medium text-sm">Alamat</label>
                        <textarea class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" id="alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="nomor_telepon" class="block mb-2 text-gray-700 font-medium text-sm">Nomor Telepon</label>
                        <input type="text" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" id="nomor_telepon" name="nomor_telepon">
                    </div>
                </form>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closePelangganModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" class="px-4 py-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-300" id="btnSimpanTransaksi">
                    <i class="fas fa-save mr-2"></i> Simpan Transaksi
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
    function closePelangganModal() {
        document.getElementById('modalPelanggan').classList.add('hidden');
    }
    
    function showPelangganModal() {
        document.getElementById('modalPelanggan').classList.remove('hidden');
    }
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
        
        showPelangganModal();
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

    // Close modal on outside click
    document.getElementById('modalPelanggan').addEventListener('click', function(e) {
        if (e.target === this) closePelangganModal();
    });

    // Initial update
    updateTotal();
});
</script>
