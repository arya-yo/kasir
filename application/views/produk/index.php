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
    <h3>Data Produk</h3>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?php echo site_url('produk/create'); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
    <?php endif; ?>
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
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <?php if ($this->session->userdata('role') == 'admin'): ?>
                <th>Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produks)): ?>
                <tr>
                    <td colspan="<?php echo $this->session->userdata('role') == 'admin' ? '5' : '4'; ?>" class="text-center">Tidak ada data produk</td>
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
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $produk->NamaProduk; ?></td>
                    <td>Rp <?php echo number_format($produk->Harga, 0, ',', '.'); ?></td>
                    <td>
                        <span class="badge <?php echo $produk->Stok > 0 ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo $produk->Stok; ?>
                        </span>
                    </td>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <td class="table-actions">
                        <button type="button" class="btn btn-sm btn-info" onclick="showDetailModal(<?php echo $produk->ProdukID; ?>)" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="showEditModal(<?php echo $produk->ProdukID; ?>)" title="Edit Produk">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteConfirm(<?php echo $produk->ProdukID; ?>, '<?php echo addslashes($produk->NamaProduk); ?>')" title="Hapus Produk">
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

<!-- Pagination -->
<?php if (!empty($produks) && $total_pages > 1): ?>
<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo site_url('produk?page=' . ($page - 1)); ?>">
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
            <a class="page-link" href="<?php echo site_url('produk?page=' . $i); ?>">
                <?php echo $i; ?>
            </a>
        </li>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo site_url('produk?page=' . ($page + 1)); ?>">
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

<!-- Modal Detail Produk -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitEditProduk()">
                    <i class="fas fa-save"></i> Simpan
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
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                <p id="deleteInfo" class="text-muted"><small>Nama Produk: <strong id="produkName"></strong></small></p>
                <p class="text-muted"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
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
    let currentProdukID = null;

    function showDetailModal(produkID) {
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        const modalBody = document.getElementById('modalBody');
        
        // Load detail via AJAX
        fetch('<?php echo site_url('produk/getDetail'); ?>/' + produkID)
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

    function showEditModal(produkID) {
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        const editModalBody = document.getElementById('editModalBody');
        
        // Load edit form via AJAX
        fetch('<?php echo site_url('produk/getEdit'); ?>/' + produkID)
            .then(response => response.text())
            .then(data => {
                editModalBody.innerHTML = data;
            })
            .catch(error => {
                editModalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat form</div>';
                console.error('Error:', error);
            });
        
        modal.show();
    }

    function submitEditProduk() {
        const produkID = editProdukID;
        const nama_produk = document.getElementById('nama_produk').value;
        const harga = document.getElementById('harga').value;
        const stok = document.getElementById('stok').value;
        
        if (!nama_produk || !harga || stok === '') {
            alert('Semua field harus diisi');
            return;
        }
        
        const formData = new FormData();
        formData.append('nama_produk', nama_produk);
        formData.append('harga', harga);
        formData.append('stok', stok);
        
        fetch('<?php echo site_url('produk/update'); ?>/' + produkID, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                
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
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Gagal menyimpan data');
            console.error('Error:', error);
        });
    }

    function showDeleteConfirm(produkID, produkName) {
        currentProdukID = produkID;
        document.getElementById('produkName').textContent = produkName;
        
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }

    function confirmDelete() {
        if (!currentProdukID) return;
        
        // Tutup modal
        bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
        
        fetch('<?php echo site_url('produk/delete'); ?>/' + currentProdukID, {
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

