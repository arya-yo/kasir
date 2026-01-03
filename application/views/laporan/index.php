<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h3>
        <div class="px-4 py-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg font-semibold">
            Total Penjualan: Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?>
        </div>
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
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Pelanggan</th>
                    <th class="px-4 py-3 text-left">Total Harga</th>
                    <th class="px-4 py-3 text-right pr-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($penjualans)): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada data penjualan</td>
                    </tr>
                <?php else: ?>
                    <?php 
                        $page = isset($page) ? $page : 1;
                        $per_page = 10;
                        $total = count($penjualans);
                        $start = ($page - 1) * $per_page;
                        $penjualans_page = array_slice($penjualans, $start, $per_page);
                        $total_pages = ceil($total / $per_page);
                        $no = $start + 1;
                    ?>
                    <?php foreach ($penjualans_page as $penjualan): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-3"><?php echo $no++; ?></td>
                        <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($penjualan->TanggalPenjualan)); ?></td>
                        <td class="px-4 py-3 font-medium"><?php echo $penjualan->NamaPelanggan ? $penjualan->NamaPelanggan : 'Umum'; ?></td>
                        <td class="px-4 py-3 font-semibold text-blue-600">Rp <?php echo number_format($penjualan->TotalHarga, 0, ',', '.'); ?></td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm transition-all duration-300 hover:shadow-md" onclick="showDetailModal(<?php echo $penjualan->PenjualanID; ?>)" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($penjualans) && $total_pages > 1): ?>
    <nav class="flex justify-center mt-6">
        <ul class="flex gap-2">
            <?php if ($page > 1): ?>
            <li>
                <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('laporan?page=' . ($page - 1)); ?>">
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
                <a class="px-4 py-2 rounded-lg transition-all duration-300 <?php echo $i == $page ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-md' : 'bg-white border border-gray-300 hover:bg-gray-50'; ?>" href="<?php echo site_url('laporan?page=' . $i); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
            <li>
                <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('laporan?page=' . ($page + 1)); ?>">
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

    <!-- Modal Detail Penjualan -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="detailModal">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 animate-scale-in max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center p-5 border-b sticky top-0 bg-white">
                <h5 class="text-lg font-semibold">Detail Penjualan</h5>
                <button type="button" onclick="closeModal('detailModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5" id="modalBody">
                <div class="text-center py-8">
                    <div class="inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            <div class="p-5 border-t flex justify-end gap-2 sticky bottom-0 bg-white">
                <button type="button" onclick="closeModal('detailModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Tutup</button>
                <button type="button" onclick="showDeleteConfirm()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-300 hover:shadow-lg" id="deleteBtn">
                    <i class="fas fa-trash mr-2"></i> Hapus
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
                <p class="mb-2">Apakah Anda yakin ingin menghapus data penjualan ini?</p>
                <p class="text-gray-600 text-sm">Tindakan ini tidak dapat dibatalkan dan semua detail penjualan akan dihapus.</p>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('confirmDeleteModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-300 hover:shadow-lg">
                    <i class="fas fa-trash mr-2"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPenjualanID = null;

    function showDetailModal(penjualanID) {
        currentPenjualanID = penjualanID;
        const modal = document.getElementById('detailModal');
        const modalBody = document.getElementById('modalBody');
        modal.classList.remove('hidden');
        
        fetch('<?php echo site_url('laporan/getDetail'); ?>/' + penjualanID)
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memuat data</div>';
                console.error('Error:', error);
            });
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function showDeleteConfirm() {
        if (!currentPenjualanID) return;
        closeModal('detailModal');
        document.getElementById('confirmDeleteModal').classList.remove('hidden');
    }

    function confirmDelete() {
        if (!currentPenjualanID) return;
        closeModal('confirmDeleteModal');
        
        fetch('<?php echo site_url('laporan/delete'); ?>/' + currentPenjualanID, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Gagal menghapus data');
            console.error('Error:', error);
        });
    }

    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
