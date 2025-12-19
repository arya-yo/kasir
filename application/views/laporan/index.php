<style>
    /* Styling untuk table action column */
    .table-actions {
        text-align: right;
        white-space: nowrap;
        padding-right: 15px !important;
    }
    
    .table-actions .btn {
        margin-left: 5px;
        margin-right: 0;
        padding: 0.375rem 0.65rem;
        font-size: 0.875rem;
    }
    
    .table thead th:last-child {
        text-align: right;
        padding-right: 15px !important;
    }
    
    /* Responsive action buttons */
    @media (max-width: 768px) {
        .table-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding-right: 10px !important;
        }
        
        .table-actions .btn {
            width: 100%;
            margin-left: 0;
            text-align: center;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Laporan Penjualan</h3>
    <div>
        <span class="badge bg-primary fs-6">Total Penjualan: Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></span>
    </div>
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

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($penjualans)): ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data penjualan</td>
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
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($penjualan->TanggalPenjualan)); ?></td>
                    <td><?php echo $penjualan->NamaPelanggan ? $penjualan->NamaPelanggan : 'Umum'; ?></td>
                    <td>Rp <?php echo number_format($penjualan->TotalHarga, 0, ',', '.'); ?></td>
                    <td class="table-actions">
                        <button type="button" class="btn btn-sm btn-info" onclick="showDetailModal(<?php echo $penjualan->PenjualanID; ?>)" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if (!empty($penjualans) && $total_pages > 1): ?>
<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo site_url('laporan?page=' . ($page - 1)); ?>">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <span class="page-link"><i class="fas fa-chevron-left"></i> Sebelumnya</span>
        </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
            <a class="page-link" href="<?php echo site_url('laporan?page=' . $i); ?>">
                <?php echo $i; ?>
            </a>
        </li>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo site_url('laporan?page=' . ($page + 1)); ?>">
                Selanjutnya <i class="fas fa-chevron-right"></i>
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <span class="page-link">Selanjutnya <i class="fas fa-chevron-right"></i></span>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>

<!-- Modal Detail Penjualan -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="deleteBtn" onclick="showDeleteConfirm()">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data penjualan ini?</p>
                <p class="text-muted"><small>Tindakan ini tidak dapat dibatalkan dan semua detail penjualan akan dihapus.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPenjualanID = null;

    function showDetailModal(penjualanID) {
        currentPenjualanID = penjualanID;
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        const modalBody = document.getElementById('modalBody');
        
        // Load detail via AJAX
        fetch('<?php echo site_url('laporan/getDetail'); ?>/' + penjualanID)
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat data</div>';
                console.error('Error:', error);
            });
        
        modal.show();
    }

    function showDeleteConfirm() {
        if (!currentPenjualanID) return;
        
        // Tutup detail modal
        bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
        
        // Buka confirm modal
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }

    function confirmDelete() {
        if (!currentPenjualanID) return;
        
        // Tutup confirm modal
        bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
        
        // Tampilkan loading di modal body
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        fetch('<?php echo site_url('laporan/delete'); ?>/' + currentPenjualanID, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan success alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-check-circle"></i> ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.insertBefore(alertDiv, document.body.firstChild);
                
                // Reload setelah 1.5 detik
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                // Tampilkan error alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle"></i> Error: ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.insertBefore(alertDiv, document.body.firstChild);
            }
        })
        .catch(error => {
            // Tampilkan error alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-circle"></i> Gagal menghapus data
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.insertBefore(alertDiv, document.body.firstChild);
            console.error('Error:', error);
        });
    }
</script>

