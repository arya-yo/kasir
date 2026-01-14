<div class="animate-fade-in">
    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Transaksi Penjualan</h3>
    </div>

    <!-- Search -->
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

    // Show flashdata messages as toasts when page loads
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($this->session->flashdata('success')): ?>
            setTimeout(() => {
                showToast('<?php echo addslashes($this->session->flashdata('success')); ?>', 'success');
            }, 100);
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            setTimeout(() => {
                showToast('<?php echo addslashes($this->session->flashdata('error')); ?>', 'error');
            }, 100);
        <?php endif; ?>
    });
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
        <nav class="flex justify-center mt-6">
            <ul class="flex gap-1">
                <?php 
                    // Use total_rows from controller for pagination calculation
                    $page = isset($page) ? $page : 1;
                    $per_page = 10;
                    $total = isset($total_rows) ? $total_rows : count($produks);
                    $total_pages = ceil($total / $per_page);
                ?>
                
                <?php if ($page > 1): ?>
                <li>
                    <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('penjualan?page=' . ($page - 1)); ?>">
                        <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                    </a>
                </li>
                <?php else: ?>
                <li>
                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                    </span>
                </li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li>
                    <a class="px-4 py-2 rounded-lg transition-all duration-300 <?php echo $i == $page ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-md' : 'bg-white border border-gray-300 hover:bg-gray-50'; ?>" href="<?php echo site_url('penjualan?page=' . $i); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                <li>
                    <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('penjualan?page=' . ($page + 1)); ?>">
                        Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                </li>
                <?php else: ?>
                <li>
                    <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">
                        Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                    </span>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
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
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-4 animate-scale-in max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h5 class="text-xl font-bold flex items-center gap-2">
                        <i class="fas fa-shopping-cart"></i> Data Pelanggan & Pembayaran
                    </h5>
                   
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <form id="formPelanggan" class="space-y-5">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Kolom Kiri: Data Pelanggan -->
                        <div class="space-y-5">
                            <h6 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                                <i class="fas fa-user-circle text-blue-600"></i> Data Pelanggan
                            </h6>
                            
                            <!-- Nama Pelanggan -->
                            <div>
                                <label for="nama_pelanggan" class="block mb-2 text-gray-700 font-semibold text-sm">
                                    <i class="fas fa-user text-blue-600 mr-1"></i> Nama Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan nama pelanggan" required>
                            </div>
                            
                            <!-- Alamat -->
                            <div>
                                <label for="alamat" class="block mb-2 text-gray-700 font-semibold text-sm">
                                    <i class="fas fa-map-marker-alt text-green-600 mr-1"></i> Alamat
                                </label>
                                <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 resize-none" id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat pelanggan (opsional)"></textarea>
                            </div>
                            
                            <!-- Nomor Telepon -->
                            <div>
                                <label for="nomor_telepon" class="block mb-2 text-gray-700 font-semibold text-sm">
                                    <i class="fas fa-phone text-purple-600 mr-1"></i> Nomor Telepon
                                </label>
                                <input type="text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300" id="nomor_telepon" name="nomor_telepon" placeholder="Masukkan nomor telepon (opsional)">
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan: Informasi Pembayaran -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 space-y-5">
                            <h6 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                                <i class="fas fa-money-bill-wave text-green-600"></i> Informasi Pembayaran
                            </h6>
                            
                            <!-- Total Harga -->
                            <div class="bg-white rounded-lg p-5 border-2 border-gray-200">
                                <p class="text-gray-700 font-semibold text-sm mb-2">Total Belanja:</p>
                                <p class="text-3xl font-bold text-blue-600" id="modalTotalHarga">Rp 0</p>
                            </div>
                            
                            <!-- Uang Pelanggan -->
                            <div>
                                <label for="uang_pelanggan" class="block mb-2 text-gray-700 font-semibold text-sm">
                                    <i class="fas fa-wallet text-orange-600 mr-1"></i> Uang Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
                                    <input type="number" class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 font-semibold text-lg" id="uang_pelanggan" name="uang_pelanggan" placeholder="0" min="0" step="1000" required>
                                </div>
                            </div>
                            
                            <!-- Kembalian -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-5 border-2 border-green-200">
                                <p class="text-gray-700 font-bold text-sm mb-3 flex items-center gap-2">
                                    <i class="fas fa-coins text-green-600"></i> Kembalian:
                                </p>
                                <p class="text-4xl font-bold text-green-600" id="kembalian">
                                    <span id="nilaiKembalian">Rp 0</span>
                                </p>
                            </div>
                            
                            <!-- Keterangan -->
                            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-3">
                                <p class="text-xs text-yellow-800 flex items-start gap-2">
                                    <i class="fas fa-info-circle text-yellow-600 mt-0.5 flex-shrink-0"></i>
                                    <span><strong>Catatan:</strong> Kembalian dihitung otomatis. Jika negatif (-), uang kurang.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end gap-3">
                <button type="button" onclick="closePelangganModal()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-300 hover:shadow-md">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button type="button" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed" id="btnSimpanTransaksi">
                    <i class="fas fa-save mr-2"></i> Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Definisikan fungsi global di luar DOMContentLoaded
function closePelangganModal() {
    const modal = document.getElementById('modalPelanggan');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showPelangganModal() {
    const modal = document.getElementById('modalPelanggan');
    const totalHargaSpan = document.getElementById('totalHarga');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Update total harga di modal
    const total = parseFloat(totalHargaSpan.textContent.replace(/[^\d]/g, '')) || 0;
    document.getElementById('modalTotalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
    
    // Reset uang pelanggan dan kembalian
    const uangPelangganInput = document.getElementById('uang_pelanggan');
    if (uangPelangganInput) {
        uangPelangganInput.value = '';
    }
    document.getElementById('nilaiKembalian').textContent = 'Rp 0';
    document.getElementById('kembalian').classList.remove('text-red-600');
    document.getElementById('kembalian').classList.add('text-green-600');
    const kembalianBox = document.getElementById('kembalian').parentElement;
    kembalianBox.classList.remove('from-red-50', 'to-rose-50', 'border-red-200');
    kembalianBox.classList.add('from-green-50', 'to-emerald-50', 'border-green-200');
    
    // Disable tombol simpan saat modal dibuka
    document.getElementById('btnSimpanTransaksi').disabled = true;
    
    // Focus ke input uang pelanggan
    setTimeout(() => {
        if (uangPelangganInput) {
            uangPelangganInput.focus();
        }
    }, 300);
}

function hitungKembalian() {
    const total = parseFloat(document.getElementById('totalHarga').textContent.replace(/[^\d]/g, '')) || 0;
    const uangPelangganInput = document.getElementById('uang_pelanggan');
    if (!uangPelangganInput) return;
    
    const uangPelanggan = parseFloat(uangPelangganInput.value) || 0;
    const kembalian = uangPelanggan - total;
    
    // Update tampilan kembalian dengan indikator minus
    const nilaiKembalian = document.getElementById('nilaiKembalian');
    const kembalianElement = document.getElementById('kembalian');
    
    if (kembalian < 0) {
        // Tampilkan dengan minus di depan
        nilaiKembalian.textContent = '- Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
        kembalianElement.classList.remove('text-green-600');
        kembalianElement.classList.add('text-red-600');
        kembalianElement.parentElement.classList.remove('from-green-50', 'to-emerald-50', 'border-green-200');
        kembalianElement.parentElement.classList.add('from-red-50', 'to-rose-50', 'border-red-200');
    } else {
        nilaiKembalian.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
        kembalianElement.classList.remove('text-red-600');
        kembalianElement.classList.add('text-green-600');
        kembalianElement.parentElement.classList.remove('from-red-50', 'to-rose-50', 'border-red-200');
        kembalianElement.parentElement.classList.add('from-green-50', 'to-emerald-50', 'border-green-200');
    }
    
    // Enable/disable tombol simpan berdasarkan kembalian
    const btnSimpan = document.getElementById('btnSimpanTransaksi');
    if (uangPelanggan >= total && uangPelanggan > 0) {
        btnSimpan.disabled = false;
    } else {
        btnSimpan.disabled = true;
    }
}

function showToast(message, type = 'success', duration = 3500) {
    const toastContainer = document.getElementById('toastContainer');
    
    // Determine colors based on type
    let bgColor, borderColor, textColor, icon;
    switch(type) {
        case 'success':
            bgColor = 'bg-gradient-to-r from-green-50 to-emerald-50';
            borderColor = 'border-green-300';
            textColor = 'text-green-800';
            icon = 'fas fa-check-circle text-green-600';
            break;
        case 'error':
            bgColor = 'bg-gradient-to-r from-red-50 to-pink-50';
            borderColor = 'border-red-300';
            textColor = 'text-red-800';
            icon = 'fas fa-exclamation-circle text-red-600';
            break;
        case 'warning':
            bgColor = 'bg-gradient-to-r from-yellow-50 to-orange-50';
            borderColor = 'border-yellow-300';
            textColor = 'text-yellow-800';
            icon = 'fas fa-exclamation-triangle text-yellow-600';
            break;
        default:
            bgColor = 'bg-gradient-to-r from-blue-50 to-cyan-50';
            borderColor = 'border-blue-300';
            textColor = 'text-blue-800';
            icon = 'fas fa-info-circle text-blue-600';
    }
    
    const toast = document.createElement('div');
    toast.className = `${bgColor} border-2 ${borderColor} ${textColor} px-5 py-4 rounded-lg shadow-lg animate-fade-in flex items-start gap-3 min-w-max max-w-sm`;
    
    toast.innerHTML = `
        <i class="${icon} flex-shrink-0 mt-0.5 text-lg"></i>
        <div class="flex-1">
            <p class="font-semibold text-sm">${message}</p>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="flex-shrink-0 text-xl hover:opacity-70 transition-opacity">
            &times;
        </button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto remove after duration
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, duration);
}

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.produk-checkbox');
    const jumlahInputs = document.querySelectorAll('.jumlah-input');
    const btnMinus = document.querySelectorAll('.btn-minus');
    const btnPlus = document.querySelectorAll('.btn-plus');
    const totalHargaSpan = document.getElementById('totalHarga');
    const btnProsesTransaksi = document.getElementById('btnProsesTransaksi');
    const formPenjualan = document.getElementById('formPenjualan');
    const modalPelanggan = document.getElementById('modalPelanggan');
    
    // Event listener untuk uang pelanggan
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'uang_pelanggan') {
            hitungKembalian();
        }
    });
    
    document.addEventListener('keyup', function(e) {
        if (e.target && e.target.id === 'uang_pelanggan') {
            hitungKembalian();
        }
    });

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
            showToast('Pilih minimal satu produk!', 'warning');
            return;
        }
        
        showPelangganModal();
    });

    // Handle simpan transaksi
    document.getElementById('btnSimpanTransaksi').addEventListener('click', function() {
        const namaPelanggan = document.getElementById('nama_pelanggan').value.trim();
        const uangPelanggan = parseFloat(document.getElementById('uang_pelanggan').value) || 0;
        const total = parseFloat(totalHargaSpan.textContent.replace(/[^\d]/g, '')) || 0;
        
        if (!namaPelanggan) {
            showToast('Nama pelanggan harus diisi!', 'warning');
            document.getElementById('nama_pelanggan').focus();
            return;
        }
        
        if (!uangPelanggan || uangPelanggan <= 0) {
            showToast('Uang pelanggan harus diisi!', 'warning');
            document.getElementById('uang_pelanggan').focus();
            return;
        }
        
        if (uangPelanggan < total) {
            showToast('Uang pelanggan tidak mencukupi!', 'error');
            document.getElementById('uang_pelanggan').focus();
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
        
        // Tambahkan hidden input untuk uang pelanggan dan kembalian
        let inputUangPelanggan = document.createElement('input');
        inputUangPelanggan.type = 'hidden';
        inputUangPelanggan.name = 'uang_pelanggan';
        inputUangPelanggan.value = uangPelanggan;
        formPenjualan.appendChild(inputUangPelanggan);
        
        let inputKembalian = document.createElement('input');
        inputKembalian.type = 'hidden';
        inputKembalian.name = 'kembalian';
        inputKembalian.value = uangPelanggan - total;
        formPenjualan.appendChild(inputKembalian);
        
        // Disable button saat submit
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...';
        
        // Submit form
        formPenjualan.submit();
    });

    // Close modal on outside click
    modalPelanggan.addEventListener('click', function(e) {
        if (e.target === this) closePelangganModal();
    });

    // Initial update
    updateTotal();
});
</script>
