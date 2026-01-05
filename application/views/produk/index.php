<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Data Produk</h3>
        <?php if ($this->session->userdata('role') == 'admin'): ?>
        <button onclick="showCreateModal()" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:scale-105">
            <i class="fas fa-plus mr-2"></i> Tambah Produk
        </button>
        <?php endif; ?>
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

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Produk</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <th class="px-4 py-3 text-right pr-4">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($produks)): ?>
                    <tr>
                        <td colspan="<?php echo $this->session->userdata('role') == 'admin' ? '5' : '4'; ?>" class="px-4 py-8 text-center text-gray-500">Tidak ada data produk</td>
                    </tr>
                <?php else: ?>
                    <?php 
                        $page = isset($page) ? $page : 1;
                        $per_page = 10;
                        $total = count($produks);
                        $start = ($page - 1) * $per_page;
                        $produks_page = array_slice($produks, $start, $per_page);
                        $total_pages = ceil($total / $per_page);
                        $no = $start + 1;
                    ?>
                    <?php foreach ($produks_page as $produk): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-3"><?php echo $no++; ?></td>
                        <td class="px-4 py-3 font-medium"><?php echo $produk->NamaProduk; ?></td>
                        <td class="px-4 py-3">Rp <?php echo number_format($produk->Harga, 0, ',', '.'); ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold <?php echo $produk->Stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $produk->Stok; ?>
                            </span>
                        </td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm mr-1 transition-all duration-300 hover:shadow-md" onclick="showDetailModal(<?php echo $produk->ProdukID; ?>)" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-sm mr-1 transition-all duration-300 hover:shadow-md" onclick="showEditModal(<?php echo $produk->ProdukID; ?>)" title="Edit Produk">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm transition-all duration-300 hover:shadow-md" onclick="showDeleteConfirm(<?php echo $produk->ProdukID; ?>, '<?php echo addslashes($produk->NamaProduk); ?>')" title="Hapus Produk">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($produks) && $total_pages > 1): ?>
    <nav class="flex justify-center mt-6">
        <ul class="flex gap-2">
            <?php if ($page > 1): ?>
            <li>
                <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('produk?page=' . ($page - 1)); ?>">
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
                <a class="px-4 py-2 rounded-lg transition-all duration-300 <?php echo $i == $page ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-md' : 'bg-white border border-gray-300 hover:bg-gray-50'; ?>" href="<?php echo site_url('produk?page=' . $i); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
            <li>
                <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('produk?page=' . ($page + 1)); ?>">
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

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Modal Create Produk -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="createModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Tambah Produk Baru</h5>
                <button type="button" onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5">
                <form id="createProdukForm" class="space-y-4">
                    <!-- Nama Produk -->
                    <div>
                        <label for="create_nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag text-blue-600 mr-1"></i> Nama Produk
                        </label>
                        <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" id="create_nama_produk" name="nama_produk" placeholder="Nama produk" required>
                    </div>
                    
                    <!-- Harga -->
                    <div>
                        <label for="create_harga" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-money-bill-wave text-green-600 mr-1"></i> Harga (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" id="create_harga" name="harga" placeholder="0" min="1" required>
                        </div>
                    </div>
                    
                    <!-- Stok -->
                    <div>
                        <label for="create_stok" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-boxes text-orange-600 mr-1"></i> Stok
                        </label>
                        <input type="number" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300" id="create_stok" name="stok" placeholder="0" min="0" required>
                    </div>
                </form>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="submitCreateProduk()" class="px-4 py-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="detailModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Detail Produk</h5>
                <button type="button" onclick="closeModal('detailModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5" id="modalBody">
                <div class="text-center py-8">
                    <div class="inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            <div class="p-5 border-t flex justify-end">
                <button type="button" onclick="closeModal('detailModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="editModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Edit Produk</h5>
                <button type="button" onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5" id="editModalBody">
                <div class="text-center py-8">
                    <div class="inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="submitEditProduk()" class="px-4 py-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="confirmDeleteModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 border-2 border-red-500 animate-scale-in">
            <div class="bg-red-500 text-white p-5 rounded-t-lg">
                <h5 class="text-lg font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Hapus</h5>
            </div>
            <div class="p-5">
                <p class="mb-2">Apakah Anda yakin ingin menghapus produk ini?</p>
                <p id="deleteInfo" class="text-gray-600 text-sm mb-2">Nama Produk: <strong id="produkName"></strong></p>
                <p class="text-gray-600 text-sm">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('confirmDeleteModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-300 hover:shadow-lg">
                    <i class="fas fa-trash mr-2"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>

<script>
    let currentProdukID = null;

    function showDetailModal(produkID) {
        const modal = document.getElementById('detailModal');
        const modalBody = document.getElementById('modalBody');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        fetch('<?php echo site_url('produk/getDetail'); ?>/' + produkID)
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memuat data</div>';
                console.error('Error:', error);
            });
    }

    function showCreateModal() {
        const modal = document.getElementById('createModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Reset form
        document.getElementById('createProdukForm').reset();
    }

    function showEditModal(produkID) {
        const modal = document.getElementById('editModal');
        const editModalBody = document.getElementById('editModalBody');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        fetch('<?php echo site_url('produk/getEdit'); ?>/' + produkID)
            .then(response => response.text())
            .then(data => {
                editModalBody.innerHTML = data;
            })
            .catch(error => {
                editModalBody.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memuat form</div>';
                console.error('Error:', error);
            });
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
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

    function submitCreateProduk() {
        const nama_produk = document.getElementById('create_nama_produk');
        const harga = document.getElementById('create_harga');
        const stok = document.getElementById('create_stok');
        
        const nama_produk_value = nama_produk.value.trim();
        const harga_value = harga.value.trim();
        const stok_value = stok.value.trim();
        
        // Validasi nilai
        if (!nama_produk_value) {
            showToast('Nama Produk harus diisi', 'warning');
            nama_produk.focus();
            return;
        }
        if (!harga_value || parseInt(harga_value) < 1) {
            showToast('Harga harus diisi dan minimal 1', 'warning');
            harga.focus();
            return;
        }
        if (stok_value === '' || parseInt(stok_value) < 0) {
            showToast('Stok harus diisi dan tidak boleh negatif', 'warning');
            stok.focus();
            return;
        }
        
        const formData = new FormData();
        formData.append('nama_produk', nama_produk_value);
        formData.append('harga', harga_value);
        formData.append('stok', stok_value);
        
        // Disable button saat submit
        const submitBtn = event.target;
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...';
        }
        
        fetch('<?php echo site_url('produk/store'); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Produk berhasil ditambahkan!', 'success');
                closeModal('createModal');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Error: ' + (data.message || 'Gagal menyimpan data'), 'error');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
                }
            }
        })
        .catch(error => {
            showToast('Gagal menyimpan data: ' + error.message, 'error');
            console.error('Error:', error);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
            }
        });
    }

    function submitEditProduk() {
        const form = document.getElementById('editProdukForm');
        
        if (!form) {
            showToast('Form tidak ditemukan. Silakan buka modal edit kembali.', 'error');
            return;
        }
        
        // Ambil ID dari form attribute
        const editProdukID = form.getAttribute('data-produk-id');
        
        if (!editProdukID || editProdukID === '') {
            showToast('ID Produk tidak ditemukan. Silakan buka modal edit kembali.', 'error');
            return;
        }

        const nama_produk = document.getElementById('nama_produk');
        const harga = document.getElementById('harga');
        const stok = document.getElementById('stok');
        
        // Validasi elemen form ada
        if (!nama_produk || !harga || !stok) {
            showToast('Form tidak lengkap. Silakan buka modal edit kembali.', 'error');
            return;
        }
        
        const nama_produk_value = nama_produk.value.trim();
        const harga_value = harga.value.trim();
        const stok_value = stok.value.trim();
        
        // Validasi nilai
        if (!nama_produk_value) {
            showToast('Nama Produk harus diisi', 'warning');
            nama_produk.focus();
            return;
        }
        if (!harga_value || parseInt(harga_value) < 1) {
            showToast('Harga harus diisi dan minimal 1', 'warning');
            harga.focus();
            return;
        }
        if (stok_value === '' || parseInt(stok_value) < 0) {
            showToast('Stok harus diisi dan tidak boleh negatif', 'warning');
            stok.focus();
            return;
        }
        
        const formData = new FormData();
        formData.append('nama_produk', nama_produk_value);
        formData.append('harga', harga_value);
        formData.append('stok', stok_value);
        
        // Disable button saat submit
        const submitBtn = event.target || document.querySelector('button[onclick="submitEditProduk()"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...';
        }
        
        fetch('<?php echo site_url('produk/update'); ?>/' + editProdukID, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Produk berhasil disimpan!', 'success');
                closeModal('editModal');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Error: ' + (data.message || 'Gagal menyimpan data'), 'error');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
                }
            }
        })
        .catch(error => {
            showToast('Gagal menyimpan data: ' + error.message, 'error');
            console.error('Error:', error);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
            }
        });
    }

    function showDeleteConfirm(produkID, produkName) {
        currentProdukID = produkID;
        document.getElementById('produkName').textContent = produkName;
        document.getElementById('confirmDeleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function confirmDelete() {
        if (!currentProdukID) return;
        closeModal('confirmDeleteModal');
        
        fetch('<?php echo site_url('produk/delete'); ?>/' + currentProdukID, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Produk berhasil dihapus!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Error: ' + (data.message || 'Gagal menghapus data'), 'error');
            }
        })
        .catch(error => {
            showToast('Gagal menghapus data: ' + error.message, 'error');
            console.error('Error:', error);
        });
    }

    // Modal behavior configured - can only close with button clicks
</script>

